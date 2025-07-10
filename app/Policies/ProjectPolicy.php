<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_project');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        // Original Version
        // return $user->can('view_project');

        /**
         * 10/07/2025 - Penambahan logika model
         * Skenario: Siapa yang boleh melihat detail satu proyek?
         * Aturan: Boleh jika ia punya izin umum atau ia adalah PM proyek ini dan atau ia adalah tim proyek ini.
         */
        if ($user->can('view_project')) {
            return true;
        }

        return $user->id === $project->project_manager_id || $project->team->contains($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_project');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        // Original Version
        // return $user->can('update_project');

        /**
         * 10/07/2025 - Penambahan logika model
         * Skenario: Siapa yang boleh mengedit proyek?
         * Aturan: Boleh jika ia punya izin umum atau ia adalah PM proyek ini.
         */
        if ($user->can('update_project')) {
            return true;
        }

        return $user->id === $project->project_manager_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->can('delete_project');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_project');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $user->can('force_delete_project');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_project');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Project $project): bool
    {
        return $user->can('restore_project');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_project');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Project $project): bool
    {
        return $user->can('replicate_project');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_project');
    }
}
