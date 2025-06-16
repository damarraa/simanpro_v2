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
        $roles = ['Admin', 'Finance', 'Project Manager', 'Supervisor', 'Petugas'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Make permissions
        $permissions = [
            'view users', 'edit users', 'delete users', 'create users', // Modul user management
            'view projects', 'edit projects', 'delete projects', 'create projects', // Modul projects
            // Type rest permissions here...
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
