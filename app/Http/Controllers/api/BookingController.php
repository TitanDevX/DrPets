<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;
class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService){}

    public function index(){


        $user = auth()->user();
        $bookings = $this->bookingService->all($user, request()->all());

        return $this->res(BookingResource::collection($bookings));
    }
}