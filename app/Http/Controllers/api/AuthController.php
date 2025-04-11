<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\RoleUser;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $guard = 'sanctum';

    public function __construct(protected AuthService $authService){



    }
    public function register(RegisterUserRequest $request){
        
        $data = $request->validated();
        $user = $this->authService->register($data);
        
        return $this->res(UserResource::make($user));
    }
    public function index(){
       
        $user = Auth::user();
        $user->load('profile');
       
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
}
