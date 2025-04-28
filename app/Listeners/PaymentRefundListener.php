<?php

namespace App\Listeners;

use App\Events\PaymentRefundEvent;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentRefundListener
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
    public function handle(PaymentRefundEvent $event): void
    {
        $payment = $event->payment;
        $this->notificationService->send($payment->invoice->user->fcm_token,[
            __('notif.payment_refund_title',['id' => $payment->id]),
            __('notif.payment_refund_body',['id' => $payment->id, 'cause' => $event->cause])],
        ['payment_id' => $payment->id,
    'cause' => $event->cause]);

    
    }
}
