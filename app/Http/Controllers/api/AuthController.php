<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Resources\UserResource;
use App\Models\RoleUser;
use App\Models\User;
use App\Services\AuthService;
use App\Services\VerificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $guard = 'sanctum';

    public function __construct(protected AuthService $authService,
    protected VerificationService $verificationService){



    }
    public function register(RegisterUserRequest $request){
        
        $data = $request->validated();
        $user = $this->authService->register($data);
        
        return $this->res(UserResource::make($user));
    }
  
    public function login(LoginUserRequest $request){
        
        
        $data = $request->validated();
        
        $user = $this->authService->login($data);

        if(!$user){
            return $this->res(message: 'The provided credentials are incorrect.', code: 401);
        }else{
            $token = $user->createToken('auth_token')->plainTextToken;
            
            //if ($request->hasHeader('X-Requested-With') && $request->header('X-Requested-With') === 'MobileApp') {
               
                return $this->res([
                    'name' => $user->name,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]);
            // }else{
            //  $cookie = cookie('auth_token', $token, 60 * 24); 
                
            //   //  $request->session()->regenerate();
               
            //     return $this->res(['name' => $user->name],'success')->withCookie($cookie);
            // }
           
        }
        
    }
    public function logout(){
      
        request()->user()->currentAccessToken()->delete();
 
    return $this->res();
    }
    public function verifyEmail(VerifyEmailRequest $request){
        $data = $request->validated();

        $user = Auth::user();
        Cache::forget($user->email . '_otp');
        $user->markEmailAsVerified();

        return $this->res(['Successfully verified email.']);
    }
    public function resendOtp(){
        $user = Auth::user();
        $untilReset = $this->verificationService->timeUntilCanResend($user);
        if($untilReset > 0){
            return $this->res(["Please wait " . $untilReset . " seconds before resending otp."]);
        }
        $this->verificationService->sendEmail($user);
        return $this->res(['Successfully resent otp.']);
    }
}
