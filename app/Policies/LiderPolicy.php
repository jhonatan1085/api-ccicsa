<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class LiderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAnyLider(User $user): bool
    {
        if($user->can('list_lider')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewLider(User $user, User $model): bool
    {
        if($user->can('edit_lider')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function createLider(User $user): bool
    {
        if($user->can('register_lider')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateLider(User $user, User $model): bool
    {
        if($user->can('edit_lider')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteLider(User $user, User $model): bool
    {
        if($user->can('delete_lider')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
