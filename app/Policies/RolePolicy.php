<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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
        return $user->can('view_any::role');
        // return $user->can('view_any_role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        /**
         * Penambahan logika pengaman.
         * Skenario: Siapa yang boleh melihat detail satu role?
         * Aturan: Tidak boleh melihat detail Super Admin (kecuali diri sendiri)
         */
        if ($role->name === 'Super Admin' && !$user->hasRole('Super Admin')) {
            return false;
        }
        return $user->can('view::role');

        // return $user->can('view_role');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create::role');
        // return $user->can('create_role');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        /**
         * Penambahan logika pengaman.
         * Skenario: Siapa yang boleh mengedit role?
         * Aturan: Tidak boleh mengedit role Super Admin.
         */
        if ($role->name === 'Super Admin') {
            return false;
        }
        return $user->can('update::role');

        // return $user->can('update_role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        /**
         * Penambahan logika pengaman.
         * Skenario: Siapa yang boleh menghapus role?
         * Aturan: Tidak boleh menghapus role Super Admin.
         */
        if ($role->name === 'Super Admin') {
            return false;
        }
        return $user->can('delete::role');

        // return $user->can('delete_role');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any::role');
        // return $user->can('delete_any_role');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        /**
         * Penambahan logika pengaman.
         * Skenario dan aturan sama dengan method delete.
         */
        if ($role->name === 'Super Admin') {
            return false;
        }
        return $user->can('force_delete::role');

        // return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any::role');
        // return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Role $role): bool
    {
        /**
         * Penambahan logika pengaman.
         * Skenario dan aturan sama dengan method delete.
         */
        if ($role->name === 'Super Admin') {
            return false;
        }
        return $user->can('restore::role');

        // return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any::role');
        // return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Role $role): bool
    {
        /**
         * Penambahan logika pengaman.
         * Skenario dan aturan sama dengan method delete.
         */
        if ($role->name === 'Super Admin') {
            return false;
        }
        return $user->can('replicate::role');

        // return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder::role');
        // return $user->can('{{ Reorder }}');
    }
}
