<?php

namespace App\Services;

use App\Models\Payment;


class PaymentService
{
    public function __construct(protected StripeService $stripeService)
    {
        
    }
    public function userPayments($user){

        return Payment::where('user_id' , '=', $user->id)->get();

    }
    public function store($data)
    {
        $payment = Payment::create($data);
        $session = $this->stripeService->createCheckoutSession($payment);
        return $payment;
    }

}