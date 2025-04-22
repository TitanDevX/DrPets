<?php

namespace App\Services;

use App\Models\Chat;


class ChatService
{

    public function openChat($user, $booking): Chat{
        $chat = Chat::create([
            'user_id' => $user->id,
            'service_id' => $booking->service_id,
            'provider_id' => $booking->service->provider_id
        ]);
        return $chat;
    }


}