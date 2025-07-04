<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectManager = User::whereHas('roles', fn($q) => $q->where('name', 'Project Manager'))->first();

        $project = Project::create([
            'client_id' => 1,
            'job_id' => 1,
            'project_manager_id' => $projectManager->id,
            'default_warehouse_id' => 1,
            'contract_type' => 'Testing',
            'contract_num' => 'SIMANPRO/2025/001',
            'job_name' => 'Pembangunan Gedung Kantor 2 Lantai',
            'fund_source' => 'Pribadi',
            'location' => 'Jl. Setia Budi',
            'start_date' => now()->subDays(10),
            'end_date' => now()->addMonths(6),
            'contract_value' => 500000000,
            'total_budget' => 450000000,
            'latitude' => 123456,
            'longitude' => 123456,
            'status' => 'On-Progress',
        ]);

        $project->team()->attach($projectManager->id);
    }
}
