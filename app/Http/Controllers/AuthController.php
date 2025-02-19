<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\json;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
           $user = Auth::user();
           $token = $user->createToken('auth_token')->plainTextToken;
           $isStudent = Student::where('users_id',$user->id)->exists();

            if ($isStudent)
            {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user'=>[
                        'id' => $user->id,
                        'name'=> $user->name,
                        'CompleteStudentRecord'=>$isStudent
                    ]
                ]);
            }else
            {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user'=>[
                        'name'=> $user->name,
                        'CompleteStudentRecord'=>$isStudent
                    ]
                ]);
            }


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
