<?php

namespace App\Policies\Settings;

use App\Models\Settings\MobilityType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MobilityTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isRoot() || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MobilityType $mobilityType): bool
    {
        return $user->isRoot() || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isRoot() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MobilityType $mobilityType): bool
    {
        return $user->isRoot() || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MobilityType $mobilityType): bool
    {
        return $user->isRoot() || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MobilityType $mobilityType): bool
    {
        return $user->isRoot() || $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MobilityType $mobilityType): bool
    {
        return $user->isRoot() || $user->isAdmin();
    }
}
