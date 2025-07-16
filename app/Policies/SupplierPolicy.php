<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
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
        return $user->can('view_any::supplier');
        // return $user->can('view_any_supplier');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Supplier $supplier): bool
    {
        return $user->can('view::supplier');
        // return $user->can('view_supplier');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create::supplier');
        // return $user->can('create_supplier');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Supplier $supplier): bool
    {
        return $user->can('update::supplier');
        // return $user->can('update_supplier');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Supplier $supplier): bool
    {
        return $user->can('delete::supplier');
        // return $user->can('delete_supplier');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any::supplier');
        // return $user->can('delete_any_supplier');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Supplier $supplier): bool
    {
        return $user->can('force_delete::supplier');
        // return $user->can('force_delete_supplier');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any::supplier');
        // return $user->can('force_delete_any_supplier');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Supplier $supplier): bool
    {
        return $user->can('restore::supplier');
        // return $user->can('restore_supplier');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any::supplier');
        // return $user->can('restore_any_supplier');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Supplier $supplier): bool
    {
        return $user->can('replicate::supplier');
        // return $user->can('replicate_supplier');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder::supplier');
        // return $user->can('reorder_supplier');
    }
}
