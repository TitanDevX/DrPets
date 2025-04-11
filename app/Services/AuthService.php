<?php
namespace App\Services;

use App\Mail\VerificationEmail;
use App\Models\User;
use Auth;
use Hash;

class AuthService {
    public function __construct(protected VerificationService $verificationService){}

    public function register($data) {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $this->verificationService->sendEmail($user);
        Auth::login($user,true);
        return $user;
    }
    public function login($data) {
        if(!Auth::attempt($data)){
            return null;
        }else{
            $user = Auth::user();
            return $user;
        }
    }

}