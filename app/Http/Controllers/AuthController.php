<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassesAuthRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\json;
use App\Services\Query\UserQueryService;
use App\Services\Query\StudentQueryService;

class AuthController extends Controller
{
    
    protected UserQueryService $userQueryService;
    protected StudentQueryService $studentQueryService;

    public function __construct(UserQueryService $userQueryService, StudentQueryService $studentQueryService)
    {
        $this->userQueryService = $userQueryService;
        $this->studentQueryService = $studentQueryService;
    }

    private const ROLES = [
        'ADMIN' => 'admin',
        'TEACHER' => 'teacher'
    ];
    public function login(ClassesAuthRequest $request)
    {
        $request->validated();

        if (!$this->validateApplicationSource($request)){
            return $this->errorResponse('Application source header is required', 400);
        }

        if (!$this->userExists($request->email)) {
            return  $this->errorResponse('User not found', 404);
        }

        if (!$this->attempAuthentication($request)) {
            return $this->errorResponse('User already Unauthorized', 401);
        }
        $user = Auth::user();
        if ($this->isDashBoardAccess($request) && !$this->isAdminOrTeacher($user)) {
            return $this->errorResponse('Unauthorized', 401);
        }
        return $this->successFulLoginResponse($user);
    }
    private function successFulLoginResponse(User $user)
    {
        $token = $user->createToken('auth_token')->plainTextToken;
        $isStudent = $this->studentQueryService->getStudentByUserId($user->id) !== null;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'CompleteStudentRecord' => $isStudent
            ]
        ]);

    }

    private function isAdminOrTeacher(User $user): bool
    {
        return in_array($user->role, [self::ROLES['ADMIN'], self::ROLES['TEACHER']]);
    }
    private  function  isDashBoardAccess(Request $request): bool
    {
        return $request->header('X-Application-Source') === 'dashboard';
    }
    private function attempAuthentication(Request $request):bool
    {
        return Auth::attempt($request->only('email', 'password'));
    }
    private function userExists(string $email): bool
    {
        return $this->userQueryService->getUserByEmail($email) !== null;
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
        $user = Auth::user();
        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }
        return response()->json(['message' => 'User not authenticated'], 404);
    }




    
}
