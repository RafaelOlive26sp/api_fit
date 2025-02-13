<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
           $user = Auth::user();
           $token = $user->createToken('auth_token')->plainTextToken;
           return response()->json([
               'access_token' => $token,
               'token_type' => 'Bearer',
           ]);
        }
        return  response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
    public function logout(Request $request)
    {

        if ($request->user()){
            $request->user()->currentAccessToken()->delete();
        }else{
            return response()->json(['message' => 'User not Authenticated']);
        }
        return response()->json(['message' => 'User logged out']);
    }
}
