<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login');
  }
  public function login(LoginUserRequest $request){

    $data = $request->validated();

    if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
      return redirect()->route('dashboard-analytics');
    }else{
      return redirect()->back()->with(['error' => 'The provided credentials are incorrect.']);
    }
  }
}
