<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassesAuthRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\json;

class AuthController extends Controller
{
    private const ROLES = [
        'ADMIN' => 'admin',
        'TEACHER' => 'teacher'
    ];
    public function login(ClassesAuthRequest $request)
    {
//        $request->validated();
//        $applicationSource = $request->header('X-Application-Source');
//        if(empty($applicationSource)){
//            return response()->json([
//                'message' => 'Application source header is required'
//            ], 400);
//        }
//
//
//
//        if (Auth::attempt($request->all())) {
//           $user = Auth::user();
//           $token = $user->createToken('auth_token')->plainTextToken;
//           $isStudent = Student::where('users_id',$user->id)->exists();
//
//            if ($isStudent)
//            {
//                return response()->json([
//                    'access_token' => $token,
//                    'token_type' => 'Bearer',
//                    'user'=>[
//                        'id' => $user->id,
//                        'name'=> $user->name,
//                        'CompleteStudentRecord'=>$isStudent
//                    ]
//                ]);
//            }else
//            {
//                return response()->json([
//                    'access_token' => $token,
//                    'token_type' => 'Bearer',
//                    'user'=>[
//                        'id' => false,
//                        'name'=> $user->name,
//                        'CompleteStudentRecord'=>$isStudent
//                    ]
//                ]);
//            }
//
//
//        }
//        return  response()->json([
//            'message' => 'Unauthorized'
//        ], 401);



        $request->validated();

        if (!$this->validateApplicationSource($request)){
            return $this->errorResponse('Application source header is required', 400);
        }

//        dd($request->only('email'));
        $isExistsUser = User::where('email', $request->email)->exists();
        if ($isExistsUser === false){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        if (Auth::attempt($request->only('email', 'password')) === false){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        if ($applicationSource === 'dashboard') {
            $user = Auth::user();
//            $verifiedUser = User::whereId($user->id)
//                ->whereIn('role', [self::ROLES['ADMIN'], self::ROLES['TEACHER']])
//                ->exists();
            if ($this->isAdmin($user)){
                return response()->json([
                        'message' => 'Unauthorized'
                    ], 401);

            }
            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $this->isAdmin($user)
                ]
            ]);

//            $token = $user->createToken('auth_token')->plainTextToken;
//            $isStudent = Student::where('users_id', $user->id)->exists();
//            return response()->json([
//                'access_token' => $token,
//                'token_type' => 'Bearer',
//                    'user' => [
//                        'id' => $user->id,
//                        'name' => $user->name,
//                        'CompleteStudentRecord' => $isStudent
//                    ]
//            ]);

        }

        if (Auth::attempt($request->all())) {
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
                        'id' => false,
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
    private function validateApplicationSource(Request $request): bool
    {
        return !empty($request->header('X-Application-Source'));
    }
   private function isAdmin(User $user): string
   {

         return $user->role === self::ROLES['ADMIN'] ? 'admin' : 'teacher';
   }

    private function errorResponse(string $message, int $status)
    {
        return response()->json(['message' => $message], $status);
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
