<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleAssignment;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehicleAssignmentPolicy
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
        return $user->can('view_any::vehicle_assignment');
        // return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VehicleAssignment $vehicleAssignment): bool
    {
        return $user->can('view::vehicle_assignment');
        // return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create::vehicle_assignment');
        // return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VehicleAssignment $vehicleAssignment): bool
    {
        return $user->can('update::vehicle_assignment');
        // return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VehicleAssignment $vehicleAssignment): bool
    {
        return $user->can('delete::vehicle_assignment');
        // return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, VehicleAssignment $vehicleAssignment): bool
    {
        return $user->can('restore::vehicle_assignment');
        // return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, VehicleAssignment $vehicleAssignment): bool
    {
        return $user->can('force_delete::vehicle_assignment');
        // return false;
    }
}
