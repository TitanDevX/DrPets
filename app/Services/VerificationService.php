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
    Cache::put($user->id . "_last_time_verify_email_send", now()->addSeconds(30),now()->addSeconds(30));
    Cache::put($user->email, $code, now()->addMinutes(5));
    $msg = Mail::to($user->email)->send(new VerificationEmail($user,$code ));
    if($msg ){
        
        return true;
    }else{
        return false;
    }

    }

    public function timeUntilCanResend($user){
    
        if( !Cache::has($user->id . "_last_time_verify_email_send")){
            return 0;
        }
        $time = Cache::get($user->id + "_last_time_verify_email_send");
        return Carbon::parse($time)->diffInSeconds(now());
    }



    public function handleCodeSubmittion($user, $code){
        if(!Cache::has($user->email)){
            return false;
        }
        $correctCode = Cache::get($user->email);

        if($code != $correctCode){
            return false;
        }
     
        $user->markEmailAsVerified();

        return true;
    }

}