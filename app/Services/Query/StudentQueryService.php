<?php

namespace App\Services\Query;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


class StudentQueryService
{
    /**
     * Get all students.
     *
     * @return Collection
     */
    public function getAllStudents(): Collection
    {
        return Student::all();
    }

    /**
     * Get student by ID.
     *
     * @param int $id
     * @return Student|null
     */
    public function getStudentById(int $id): ?Student
    {
        return Student::find($id);
    }

    /**
     * Get student by user ID.
     *
     * @param int $id
     * @return Student|null
     */
    public function getStudentByUserId(int $id): ?Student
    {
        return Student::where('users_id', $id)->first();
    }

}
