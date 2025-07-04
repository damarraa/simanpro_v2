<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tool::create([
            'tool_code' => 'BOR-BOSCH-01',
            'name' => 'Mesin Bor Tangan Bosch GSB 550',
            'brand' => 'Bosch',
            'purchase_date' => '2024-01-15',
            'unit_price' => 750000,
            'condition' => 'Baik',
        ]);
    }
}
