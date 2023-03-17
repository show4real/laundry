<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request){
    if(filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)){
      $user = User::where('email', $request->get('username'))->first();
      $credentials = ['email' => strtolower($request->get('username')), 'password' => $request->get('password')];
    } else {
      $user = User::where('email', $request->get('username'))->first();
      $credentials = ['phone' => $request->get('username'), 'password' => $request->get('password')];
    }

    if ((!$token = auth()->attempt($credentials)) || ($user->is_active !== 1)) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
  }
}
