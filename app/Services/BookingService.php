<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;


class BookingService
{
    public function all($user, $data, $paginated = true){

        $bookings = Booking::whereHas('pet.user', function ($query) use ($user) {
            $query->where('id','=',$user->id)
;        })
        ->when(isset($data['status']),function ($query) use ($data) {
           
            $query->whereIn('status', 
            array_map(fn($s) => BookingStatus::fromName($s)->value, $data['status']));
            
        });
       
       return$bookings->get();

    }

}