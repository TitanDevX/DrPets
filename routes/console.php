<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::call(function () {
    $bookings =Booking::where('status', 'pending')
    ->where('created_at', '<', now()->subHours(12))->get();
    foreach($bookings as $booking){
        $booking->update([
            'status' => BookingStatus::REJECTED->value
        ]);
    }    
    // TODO notify user 
})->everyMinute();
Schedule::call(function () {
    $bookings = Booking::where('status', 'accepted')
        ->whereNull('paid_at')
        ->where('accepted_at', '<', now()->subHour())->get();
    foreach($bookings as $booking){
        $booking->update([
            'status' => BookingStatus::CANCELLED->value,
        ]);
    }    
        
        // TODO notify user 
})->everyMinute();
