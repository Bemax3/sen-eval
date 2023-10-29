<?php

namespace App\Policies\Evaluation;

use App\Models\Evaluation\Goal;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class GoalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Goal $goal): bool
    {
        return $user->user_id === $goal->evaluated_id || $user->user_id === $goal->evaluator_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Goal $goal): bool
    {
//            return true;
        return $user->user_id === $goal->evaluator_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Goal $goal): bool
    {
        return $user->user_id === $goal->evaluator_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Goal $goal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Goal $goal): bool
    {
        return false;
    }
}
