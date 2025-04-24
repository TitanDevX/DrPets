<?php

namespace App\Services;

use App\Jobs\SendFirebaseNotification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;


class NotificationService
{


    public function send($token, array $notif, $data = []){
        if(!$token) return;
    
        SendFirebaseNotification::dispatch($token, $notif, $data);

    }

}