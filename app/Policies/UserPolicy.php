<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * 16/07/2025 - Modifikasi penamaan Policy.
     * Standar Filament Generate menggunakan _ (Underscore) diubah
     * menjadi :: (Double colon).
     */

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any::user');
        // return $user->can('view_any_user');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @return bool
     * 
     * 10/07/2025 - Penambahan parameter model
     */
    public function view(User $user, User $model): bool
    {
        // Original version
        // return $user->can('view_user');

        /**
         * 10/07/2025 - Penambahan logika model
         * $model disini adalah $user yang sedang coba dilihat.
         * Skenario: Siapa yang boleh melihat detail satu user?
         * Aturan: Boleh jika punya izin atau jika melihat profil sendiri.
         */
        return $user->id === $model->id || $user->can('view::user');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create::user');
        // return $user->can('create_user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        // Original version
        // return $user->can('update_user');
        
        /**
         * 10/07/2025 - Penambahan logika model
         * $model disini adalah $user yang boleh edit data user.
         * Skenario: Siapa yang boleh melihat data user?
         * Aturan: Boleh jika punya izin atau jika mengedit profil sendiri.
         */
        return $user->id === $model->id || $user->can('update::user');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        // Original Version
        // return $user->can('delete_user');

        /**
         * 10/07/2025
         * $model disini adalah user yang coba dihapus.
         * Skenario: Siapa yang boleh menghapus user?
         * Aturan: Boleh jika punya izin dan tidak sedang mencoba menghapus diri sendiri.
         */
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can('delete::user');

        // return $user->can('delete_user');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any::user');
        // return $user->can('delete_any_user');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return $user->can('force_delete::user');
        // return $user->can('force_delete_user');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any::user');
        // return $user->can('force_delete_any_user');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('restore::user');
        // return $user->can('restore_user');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any::user');
        // return $user->can('restore_any_user');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function replicate(User $user): bool
    {
        return $user->can('replicate::user');
        // return $user->can('replicate_user');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder::user');
        // return $user->can('reorder_user');
    }
}
