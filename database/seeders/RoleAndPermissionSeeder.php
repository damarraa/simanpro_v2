<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make roles
        $roles = ['Admin', 'Finance', 'Logistic', 'Project Manager', 'Supervisor', 'Petugas'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Make permissions
        $permissions = [
            'view_user', 'view_any_user', 'create_user', 'update_user', 'delete_user', 'delete_any_user', 'force_delete_user', 'force_delete_any_user', 'restore_user', 'restore_any_user', 'replicate_user', 'reorder_user',
            'view_project', 'view_any_project', 'create_project', 'update_project', 'delete_project', 'delete_any_project', 'force_delete_project', 'force_delete_any_project', 'restore_project', 'restore_any_project', 'replicate_project', 'reorder_project',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
