<?php

namespace App\Services;


class UserService
{

    public function setFcmToken($user , $data){
        $user->fcm_token = $data['fcm_token'];
        $user->save();
    }

}