<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::factory()
            ->count(5)
            ->has(Task::factory()->count(7), 'tasks')
            ->create();
    }
}
