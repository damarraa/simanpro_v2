<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create([
            'sku' => 'SMN-TR-40KG',
            'name' => 'Semen Tiga Roda 40kg',
            'unit' => 'sak',
            'is_dpt' => true,
            'supplier_id' => 1,
        ]);
    }
}
