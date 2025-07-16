<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * 16/07/2025 - Modifikasi penamaan Policy.
     * Standar Filament Generate menggunakan _ (Underscore) diubah
     * menjadi :: (Double colon).
     */

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any::vehicle');
        // return $user->can('view_any_vehicle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->can('view::vehicle');
        // return $user->can('view_vehicle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create::vehicle');
        // return $user->can('create_vehicle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->can('update::vehicle');
        // return $user->can('update_vehicle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $user->can('delete::vehicle');
        // return $user->can('delete_vehicle');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any::vehicle');
        // return $user->can('delete_any_vehicle');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Vehicle $vehicle): bool
    {
        return $user->can('force_delete::vehicle');
        // return $user->can('force_delete_vehicle');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any::vehicle');
        // return $user->can('force_delete_any_vehicle');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Vehicle $vehicle): bool
    {
        return $user->can('restore::vehicle');
        // return $user->can('restore_vehicle');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any::vehicle');
        // return $user->can('restore_any_vehicle');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Vehicle $vehicle): bool
    {
        return $user->can('replicate::vehicle');
        // return $user->can('replicate_vehicle');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder::vehicle');
        // return $user->can('reorder_vehicle');
    }
}
