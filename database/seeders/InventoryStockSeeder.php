<?php

namespace Database\Seeders;

use App\Models\InventoryStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InventoryStock::create([
            'warehouse_id' => 1,
            'material_id' => 1,
            'current_stock' => 200,
            'min_stock' => 50
        ]);
    }
}
