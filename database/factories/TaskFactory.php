<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = array_map(
            fn(TaskStatus $case) => $case->value,
            TaskStatus::cases()
        );

        return [
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'project_id' => ProjectFactory::new(),
            'status' => $statuses[array_rand($statuses)]
        ];
    }
}
