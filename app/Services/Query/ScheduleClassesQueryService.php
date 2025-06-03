<?php

namespace App\Services\Query;

use App\Models\ClassSchedulesPattern;
use Illuminate\Database\Eloquent\Collection;


class ScheduleClassesQueryService
{
    /**
     * Get all class schedules patterns.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllClassSchedulesPatterns()
    {
        return ClassSchedulesPattern::with([
            'classe',
            'classSchedule'
        ])->get();
    }

    /**
     * Get a class schedule pattern by ID.
     *
     * @param int $id
     * @return ClassSchedulesPattern|null
     */
    public function getClassSchedulePatternById(int $id): ?ClassSchedulesPattern
    {
        return ClassSchedulesPattern::with([
            'classe',
            'classSchedule'
        ])->findOrFail($id);
    }
    public function ifExistsClassSchedulePatternById(int $id): bool
    {
        return ClassSchedulesPattern::where('id', $id)->exists();
    }
}
{

}
