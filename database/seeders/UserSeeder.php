<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pm = User::create([
            'name' => 'Dummy PM',
            'email' => 'pm@example.com',
            'password' => Hash::make('testing123'),
            'is_active' => true,
        ]);

        $pm->assignRole('Project Manager');

        $logistic = User::create([
            'name' => 'Dummy Logistic',
            'email' => 'log@example.com',
            'password' => Hash::make('testing123'),
            'is_active' => true,
        ]);

        $logistic->assignRole('Logistic');
    }
}
