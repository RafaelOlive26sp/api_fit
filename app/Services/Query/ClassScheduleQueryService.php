<?php
//      * Show the form for editing the specified resource.

namespace App\Services\Query;

use App\Models\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;


class ClassScheduleQueryService
{
    /**
     * Get all class schedules.
     *
     * @return Collection
     */
    public function getAllClassSchedules(): Collection
    {
        return ClassSchedule::with('classe')->get();
    }

    /**
     * Get a class schedule by ID.
     *
     * @param int $id
     * @return ClassSchedule|null
     */
    public function getClassScheduleById(int $id): ?ClassSchedule
    {
        return ClassSchedule::with('classe')->findOrFail($id);
    }
}
