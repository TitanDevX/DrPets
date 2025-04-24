<?php

namespace App\Listeners;

use App\Events\PaymentSuccessfulEvent;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentSuccessfulListener
{
    /**
     * Create the event listener.
     */
    public function __construct(protected NotificationService $notificationService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentSuccessfulEvent $e): void
    {
        $payment = $e->payment;
        $user = $payment->invoice->user;
        $this->notificationService->send($user->fcm_token,[
            __('notif.payment_successful_title'), __('notif.payment_successful_body')],
            ['payment_id' => $payment->id]);

    }
}
