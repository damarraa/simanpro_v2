<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'CV. Jaya Abadi',
            'address' => 'Jl. Pahlawan Kerja No. 123',
            'phone' => '0761-555-111',
        ]);
    }
}
