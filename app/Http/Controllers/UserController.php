<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function __construct(protected UserService $userService){}

    public function storeFcmToken($request){
        $data = Validator::make($request->all, [
            'fcm_token' => 'required'
        ])->valiated();
        $user = auth()->user();
        $this->userService->setFcmToken($user, $data);

        return $this->res();
        
    }
}