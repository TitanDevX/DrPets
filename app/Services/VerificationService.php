<?php
namespace App\Services;

use App\Mail\VerificationEmail;
use Cache;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Notifications\Notifiable;
use Mail;
class VerificationService {

    public function sendEmail($user){

    $code = rand(111111, 999999);
    Cache::put($user->id . "_resend_delay", now()->addSeconds(30),now()->addMinutes(5));
    $time = Cache::get($user->id . "_resend_delay");

    Cache::put($user->email . '_otp', $code, now()->addMinutes(5));
    $msg = Mail::to($user->email)->send(new VerificationEmail($user,$code ));
    if($msg ){
        
        return true;
    }else{
        return false;
    }

    }

    public function timeUntilCanResend($user){
    
        if( !Cache::has($user->id . "_resend_delay")){
            return 0;
        }
   
        $time = Cache::get($user->id . "_resend_delay");

        return now()->diffInSeconds(Carbon::parse($time));
    }



   

}