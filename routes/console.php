<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Reminder;
use App\Services\BookingService;
use App\Services\NotificationService;
use App\Services\ReminderService;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::call(function () {
   
   
    try{
    $bookingService = resolve(BookingService::class);
    $bookingService->expirePendingBookings();
    }catch(\Exception $ex){
        Log::debug("Error while scheduling expirePendingBookings: " . $ex->getMessage());
    }
    Log::channel('schedules')->debug("Marked pending bookings as rejected if no response in 12 hours.");
})->everySecond();


Schedule::call(function () {

    $reminderService = resolve(ReminderService::class);
    $reminderService->sendReminders();
    Log::channel('schedules')->debug("Reminders has been sent.");
})->everyMinute();


Schedule::call(function () {
   resolve(BookingService::class)->expireAcceptedButNotPaidBookings();
    Log::channel('schedules')->debug("Expiring accepted but not paid bookings.");   

})->everyMinute();