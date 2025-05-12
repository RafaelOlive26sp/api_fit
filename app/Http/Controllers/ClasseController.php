<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassesResquest;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'Listagem de turmas';
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassesResquest $request)
    {
        $this->authorize('create', User::class);
        $validateData = $request->validated();
        Classe::create($validateData);
        return response()->json(['message'=>  'Turma criada com sucesso'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'Detalhes da turma1';
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 'Turma atualizada com sucesso';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return 'Turma removida com sucesso';
    }
}
