<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'teknisi_it@prisan.co.id',
            'password' => Hash::make('Prisan@1234'),
            'is_active' => true,
        ]);

        $superAdmin->assignRole('Super Admin');
    }
}
