<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Chat;


class ChatService
{

    public function __construct(protected BookingService $bookingService){}
    public function all($userId, $withes = [], $paginated = true){

        $chats = Chat::where('user_id' , '=', $userId)->with($withes);

        if($paginated){
            return $chats->paginate();
        }else{
            return $chats->get();
        }

    }
    public function show($id, $withes = []){

        $chats = Chat::whereKey($id)->with($withes);

       return $chats->first();

    }

    public function getChat($id){
        return Chat::find($id);
    }

    public function openChat($user, $booking): Chat{
        $chat = Chat::create([
            'user_id' => $user->id,
            'booking_id' => $booking->id,
            'provider_id' => $booking->service->provider_id
        ]);
        return $chat;
    }

    public function delete($chat, $cancelBooking = true){

        if($cancelBooking){
            $booking = $chat->booking;
            if($booking->status != BookingStatus::ACCEPTED){
                $this->bookingService->cancelBooking($booking);
            }
        }

        $chat->delete();
    
    }

}