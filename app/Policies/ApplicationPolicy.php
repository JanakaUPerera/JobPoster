<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Application $application): bool
    {
        $prepend = "$user->user_type.application.view";
        $permission = Arr::get(config('permission'),$prepend);
        $authUser = $application->applicant_id == Auth::id() || $application->jobPost->poster_id == Auth::id();
        return ($permission && $authUser);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $prepend = "$user->user_type.application.create";
        return Arr::get(config('permission'),$prepend);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Application $application): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Application $application): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Application $application): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Application $application): bool
    {
        //
    }
}
