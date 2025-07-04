<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logisticUser = User::whereHas('roles', fn($q) => $q->where('name', 'Logistic'))->first();

        Warehouse::create([
            'warehouse_name' => 'Gudang Pusat Pekanbaru',
            'address' => 'Jl. Soekarno Hatta, Pekanbaru',
            'phone' => '0761-555-222',
            'pic_user_id' => $logisticUser->id,
        ]);
    }
}
