<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Schedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param User $user
     * @return void|bool
     */
    public function before(User $user)
    {
        if ($user->hasAdminRole()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any schedules.
     *
     * @param Student $user
     * @return mixed
     */
    public function viewAny(Student $user)
    {
        //
    }

    /**
     * Determine whether the user can view the schedule.
     *
     * @param Teacher $user
     * @param Schedule $schedule
     * @return mixed
     */
    public function view(Teacher $user, Schedule $schedule)
    {
        //
    }

    /**
     * Determine whether the user can create schedules.
     *
     * @param Teacher $user
     * @return mixed
     */
    public function create(Teacher $user)
    {
        //
    }

    /**
     * Determine whether the user can update the schedule.
     *
     * @param Teacher $user
     * @param Schedule $schedule
     * @return mixed
     */
    public function update(Teacher $user, Schedule $schedule)
    {
        //
    }

    /**
     * Determine whether the user can delete the schedule.
     *
     * @param Teacher $user
     * @param Schedule $schedule
     * @return mixed
     */
    public function delete(Teacher $user, Schedule $schedule)
    {
        //
    }

    /**
     * Determine whether the user can restore the schedule.
     *
     * @param Student $user
     * @param Schedule $schedule
     * @return mixed
     */
    public function restore(Student $user, Schedule $schedule)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the schedule.
     *
     * @param Student $user
     * @param Schedule $schedule
     * @return mixed
     */
    public function forceDelete(Student $user, Schedule $schedule)
    {
        //
    }
}
