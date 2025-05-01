<?php

namespace App\Services;

use App\Models\User;


class UserService
{

    public function setFcmToken($user, $data)
    {
        $user->fcm_token = $data['fcm_token'];
        $user->save();
    }


    public function increaseRatingLimit($user)
    {
        $user->rating_limit++;

        $user->save();
    }
    public function getPfp($user)
    {
        return $user->pfp_path
            ? asset('storage/' . $user->pfp_path)
            : asset('img/default-pfp.jpg');
    }

    public function isAdmin($user){
        return $user->hasPermissionTo('dashboard.admin');
    }
    public function getUser($id)
    {

        return User::find($id);
    }

}