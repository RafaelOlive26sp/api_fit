<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserResquest;
use App\Http\Resources\UserAdministrationResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
        $this->authorize('viewAny', User::class);
        }catch (AuthorizationException $e) {
            return response()->json(['error' => $e->getMessage()], 403);

        }

        $incompleteStudents = User::doesntHave('student')->get();
        return UserAdministrationResource::collection($incompleteStudents);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(UserResquest $request)
    {
//        $this->authorize('create', User::class);
        $validateData = $request->validated();

        return User::create($validateData);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        $this->authorize('view', $user);

        return new UserResource($user);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 'Hello from UserController@index';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $this->authorize('delete', $user);

        DB::transaction(function () use ($user) {
            $user->tokens()->delete();
        });

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
