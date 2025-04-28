<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Events\PaymentRefundEvent;
use App\Events\PaymentSuccessfulEvent;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Stripe\Checkout\Session;
use App\Enums\OrderStatusEnum;
use App\Enums\PackageSubscriptionStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Order;
use App\Models\RestaurantAdminPackage;
use Stripe\Exception\ApiErrorException;
use Stripe\Refund;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;
use Log;

class StripeService
{
    protected string $stripeSecret;
    protected string $stripeKey;

    public function __construct()
    {
        $this->stripeSecret = config('services.stripe.secret');
        $this->stripeKey = config('services.stripe.key');
    }

    public function createCheckoutSession(Payment $payment)
    {
        DB::beginTransaction();
        try {
            Stripe::setApiKey($this->stripeSecret);

            $session = Session::create([
                // 'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Payment',
                        ],
                        'unit_amount' => $payment->amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'client_reference_id' => $payment->id,
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
            ]);
            $data = [
                'session_id' => $session->id,
                'session_url' => $session->url,
                'created_at' => $session->created,
                'expires_at' => $session->expires_at,
                'currency' => $session->currency,
                'livemode' => $session->livemode,
            ];
            $payment->update(['data' => json_encode($data)]);
    
            DB::commit();
        } catch (\Exception $e) {
            FacadesLog::error($e->getMessage());
            DB::rollBack();
        }
        return $payment;
    }

    public function success($data, $test = false)
    {
        DB::beginTransaction();
        try {
            $session_id = $data['session_id'];
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = Session::retrieve($session_id);
            $payment_id = $session->client_reference_id;
            /** @var \App\Models\Payment $payment */
            $payment = Payment::findOrFail($payment_id);
            if ($session->payment_status == 'paid' || $test == true) {
                if($session->amount_subtotal/100 > $payment->invoice->total){ // Happens if promocode was applied to invoice after the session got generated.

                    $this->refund([$payment], 'Got invlaid amount. amount paid is greater than invoice\'s totam amount.');
                    return "Payment is refunded. Got invlaid amount. amount paid is greater than invoice\'s totam amount.";
                }else{
                    $payment->update(['status' => PaymentStatusEnum::PAID->value]);
                    event(new PaymentSuccessfulEvent($payment));
                }
             
                

            } else if ($session->payment_status == 'unpaid') {
                $payment->update(['status' => PaymentStatusEnum::FAILED->value]);
                
            }
            
            DB::commit();
        } catch (\Exception $e) {
            FacadesLog::error($e->getMessage());
            DB::rollBack();
        }
        return $payment;
    }

    public function cancel($data)
    {
        DB::beginTransaction();
        try {
            $session_id = $data->session_id;
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = Session::retrieve($session_id);
            $payment_id = $session->client_reference_id;
            $payment = Payment::find($payment_id);
            if ($session->payment_status == 'unpaid') {
                $payment->update(['status' => PaymentStatusEnum::CANCELED->value]);

            }
          
            DB::commit();
        } catch (\Exception $e) {
            FacadesLog::error($e->getMessage());
            DB::rollBack();
        }
        return $payment;
    }

    public function refund($payments = [], $cause){
        foreach($payments as $payment){
            $data = $payment->data;
            if(!isset($data['session_id'])) continue;
            $sessionId = $data['session_id'];
            $session = Session::retrieve($sessionId);
            $paymentIntentId = $session->payment_intent;
            try{
            $refund = Refund::create([
                'payment_intent' => $paymentIntentId,
                'amount' => $payment->amount * 100,
            ]);
            }catch(ApiErrorException $e){
                continue;
            }
            event(new PaymentRefundEvent($payment, $cause));
        }
    }
}