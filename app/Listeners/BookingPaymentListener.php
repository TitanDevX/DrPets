<?php

namespace App\Listeners;

use App\Enums\BookingStatus;
use App\Events\PaymentSuccessfulEvent;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BookingPaymentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentSuccessfulEvent $e): void
    {
        
        $payment = $e->payment;
        /**  @var \App\Models\Invoice $invoice */
        $invoice = $payment->invoice;
        $items = $invoice->contents;
        if($items->count() > 1) return;

        $firstItem = $items->first();
        if($firstItem->invoicable_type != Booking::class) return;
        $booking = $firstItem->invoicable;
        
    }
}
