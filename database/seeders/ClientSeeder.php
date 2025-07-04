<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'client_name' => 'PT. Klien Sejahtera',
            'client_contact_person' => 'Bapak Budi',
            'client_phone' => '081234567890'
        ]);
    }
}
