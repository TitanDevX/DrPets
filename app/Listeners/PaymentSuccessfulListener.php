<?php

namespace App\Listeners;

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceTypeEnum;
use App\Enums\OrderStatus;
use App\Events\PaymentSuccessfulEvent;
use App\Models\Product;
use App\Services\NotificationService;
use App\Services\OrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentSuccessfulListener
{
    /**
     * Create the event listener.
     */
    public function __construct(protected NotificationService $notificationService,
    protected OrderService $orderService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentSuccessfulEvent $e): void
    {
        
        /** @var Payment $payment */
        $payment = $e->payment;
        /** @var Invoice $invoice */
        $invoice = $payment->invoice;
        $user = $invoice->user;
        $this->notificationService->send($user->fcm_token,[
            __('notif.payment_successful_title'), __('notif.payment_successful_body')],
            ['payment_id' => $payment->id]);

        if($payment->amount == $invoice->total){ // Update invoice status if the paid amount is equal to the invoice total.
            $invoice->status = InvoiceStatus::PAID;
            $invoice->save();
        }

        if($invoice->type == InvoiceTypeEnum::ORDER){
            $this->orderService->activateOrder($invoice->order);
            // TODO notify providers.
        }

    }
}
