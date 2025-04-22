<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ChatResource;
use App\Services\BookingService;
class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService){}

    public function index(){


        $user = auth()->user();
        $bookings = $this->bookingService->all($user, request()->all());

        return $this->res(BookingResource::collection($bookings));
    }
    public function book(BookRequest $request){
        $data = $request->afterValidation();
        $retu = $this->bookingService->book($data);
        
        return $this->res(
            ['booking' => BookingResource::make($retu['booking']),
             ChatResource::make($retu['chat']),'Booking created and a chat with service provider has been opened, pending provider approval and payment for booking to be submitted.']
        );
    }
}