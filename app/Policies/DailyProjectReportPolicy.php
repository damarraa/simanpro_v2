<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailyProjectReport;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyProjectReportPolicy
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
        return $user->can('view_any::daily_project_report');
        // return $user->can('view_any::daily::project::report');
        // return $user->can('view_any_daily::project::report');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DailyProjectReport $dailyProjectReport): bool
    {
        return $user->can('view::daily_project_report');
        // return $user->can('view_daily::project::report');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create::daily_project_report');
        // return $user->can('create_daily::project::report');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DailyProjectReport $dailyProjectReport): bool
    {
        return $user->can('update::daily_project_report');
        // return $user->can('update_daily::project::report');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DailyProjectReport $dailyProjectReport): bool
    {
        return $user->can('delete::daily_project_report');
        // return $user->can('delete_daily::project::report');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any::daily_project_report');
        // return $user->can('delete_any_daily::project::report');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, DailyProjectReport $dailyProjectReport): bool
    {
        return $user->can('force_delete::daily_project_report');
        // return $user->can('force_delete_daily::project::report');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any::daily_project_report');
        // return $user->can('force_delete_any_daily::project::report');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, DailyProjectReport $dailyProjectReport): bool
    {
        return $user->can('restore::daily_project_report');
        // return $user->can('restore_daily::project::report');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any::daily_project_report');
        // return $user->can('restore_any_daily::project::report');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, DailyProjectReport $dailyProjectReport): bool
    {
        return $user->can('replicate::daily_project_report');
        // return $user->can('replicate_daily::project::report');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder::daily_project_report');
        // return $user->can('reorder_daily::project::report');
    }
}
