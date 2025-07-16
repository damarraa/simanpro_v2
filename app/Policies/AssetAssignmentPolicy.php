<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AssetAssignment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetAssignmentPolicy
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
        return $user->can('view_any::asset_assignment');
        // return $user->can('view_any_asset::assignment');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AssetAssignment $assetAssignment): bool
    {
        return $user->can('view::asset_assignment');
        // return $user->can('view_asset::assignment');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create::asset_assignment');
        // return $user->can('create_asset::assignment');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AssetAssignment $assetAssignment): bool
    {
        return $user->can('update::asset_assignment');
        // return $user->can('update_asset::assignment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AssetAssignment $assetAssignment): bool
    {
        return $user->can('delete::asset_assignment');
        // return $user->can('delete_asset::assignment');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any::asset_assignment');
        // return $user->can('delete_any_asset::assignment');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, AssetAssignment $assetAssignment): bool
    {
        return $user->can('force_delete::asset_assignment');
        // return $user->can('force_delete_asset::assignment');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any::asset_assignment');
        // return $user->can('force_delete_any_asset::assignment');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, AssetAssignment $assetAssignment): bool
    {
        return $user->can('restore::asset_assignment');
        // return $user->can('restore_asset::assignment');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any::asset_assignment');
        // return $user->can('restore_any_asset::assignment');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, AssetAssignment $assetAssignment): bool
    {
        return $user->can('replicate::asset_assignment');
        // return $user->can('replicate_asset::assignment');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder::asset_assignment');
        // return $user->can('reorder_asset::assignment');
    }
}
