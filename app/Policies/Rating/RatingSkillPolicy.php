<?php

namespace App\Policies\Rating;

use App\Models\Rating\RatingSkill;
use Illuminate\Auth\Access\Response;
use LdapRecord\Models\ActiveDirectory\User;

class RatingSkillPolicy
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
    public function view(User $user, RatingSkill $ratingSkill): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RatingSkill $ratingSkill): bool
    {
        return $user->user_id == $ratingSkill->rating->evaluator_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RatingSkill $ratingSkill): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RatingSkill $ratingSkill): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RatingSkill $ratingSkill): bool
    {
        //
    }
}
