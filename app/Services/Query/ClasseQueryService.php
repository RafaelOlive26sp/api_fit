<?php

namespace App\Services\Query;

use App\Models\Classe;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


class ClasseQueryService
{
    /**
     * Get all classes.
     *
     * @return Collection
     */
    public function getAllClasses(): Collection
    {
        return Classe::with([
            'schedulesPatterns',
            'extraClasses.classe',
            'user'=> function ($query) {
                $query->select('id', 'name');
            },
        ])->select('id', 'name', 'max_students', 'level')->get();


    }

    /**
     * Get class by ID.
     *
     * @param int $id
     * @return Classe|null
     */
    public function getClassById(int $id): ?Classe
    {
        return Classe::find($id);
    }
}
