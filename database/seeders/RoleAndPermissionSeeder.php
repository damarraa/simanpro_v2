<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update Version 10/07/2025
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Membuat Roles
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleProjectManager = Role::create(['name' => 'Project Manager']);
        $roleSupervisor = Role::create(['name' => 'Supervisor']);
        $roleLogistic = Role::create(['name' => 'Logistic']);
    
        $roleAdmin->syncPermissions(Permission::all());

        $roleProjectManager->givePermissionTo([
            'view_any::project',
            'create::project',
            'update::project',
            'view_any::daily::project::report',
            'create::daily::project::report',
            'update::daily::project::report',
        ]);

        $roleSupervisor->givePermissionTo([
            'view_any::project',
            'view::project',
            'view_any::daily::project::report',
            'create::daily::project::report',
        ]);

        $roleLogistic->givePermissionTo([
            'view_any::material',
            'create::material',
            'update::material',
            'view_any::tool',
            'create::tool',
            'update::tool',
            'view_any::warehouse',
            'view_any::supplier',
            'view_any::stock::movement',
            'create::stock::movement',
        ]);

        // Original Version
        // Make roles
        // $roles = ['Admin', 'Finance', 'Logistic', 'Project Manager', 'Supervisor', 'Petugas'];

        // foreach ($roles as $role) {
        //     Role::firstOrCreate(['name' => $role]);
        // }

        // // Make permissions
        // $permissions = [
        //     'view_user', 'view_any_user', 'create_user', 'update_user', 'delete_user', 'delete_any_user', 'force_delete_user', 'force_delete_any_user', 'restore_user', 'restore_any_user', 'replicate_user', 'reorder_user',
        //     'view_project', 'view_any_project', 'create_project', 'update_project', 'delete_project', 'delete_any_project', 'force_delete_project', 'force_delete_any_project', 'restore_project', 'restore_any_project', 'replicate_project', 'reorder_project',
        // ];

        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission]);
        // }
    }
}
