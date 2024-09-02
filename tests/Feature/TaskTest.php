<?php

namespace Tests\Feature;

use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    protected bool $authenticated = true;

    public function test_tasks_can_be_listed(): void
    {
        $project = Project::factory()->has(Task::factory()->count(3))->create();

        $response = $this->get(route('projects.show', ['project' => $project]));

        $response->assertOk();
        $response->assertViewIs('project');
        $response->assertViewHas('tasks', $project->tasks);
        $response->assertSee($project->tasks->first()->name);
    }

    public function test_tasks_can_be_filtered(): void
    {
        $project = Project::factory()
            ->has(Task::factory()
                ->count(3)
                ->sequence(
                    ['status' => TaskStatus::DONE],
                    ['status' => TaskStatus::TODO],
                    ['status' => TaskStatus::IN_PROGRESS]
                ))
            ->create();

        $response = $this->get(route('projects.show', ['project' => $project, 'status' => TaskStatus::DONE->value]));

        $response->assertSee(TaskStatus::DONE->value);
    }

    public function test_task_can_be_stored(): void
    {
        $project = Project::factory()->create();

        $data = [
            'name' => 'first task',
            'description' => 'first task description',
        ];

        $response = $this->post(route('projects.tasks.store', ['project' => $project]), $data);

        $response->assertCreated()->assertJson($data);
        $this->assertDatabaseHas(Task::class, array_merge($data, ['project_id' => $project->id]));
    }

    public function test_task_can_be_updated(): void
    {
        $task = Task::factory()->create();

        $data = [
            'name' => 'first task',
            'description' => 'first task description',
        ];

        $response = $this->put(route('tasks.update', ['task' => $task]), $data);

        $response->assertOk()->assertJson($data);
        $this->assertDatabaseHas(Task::class, $data);
    }

    public function test_task_be_deleted(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', ['task' => $task]));

        $response->assertNoContent();
        $this->assertDatabaseMissing($task);
    }

    public function test_task_status_can_be_updated(): void
    {
        $task = Task::factory()->create(['status' => TaskStatus::TODO]);

        $data = [
            'status' => TaskStatus::IN_PROGRESS->value,
        ];

        $response = $this->patch(route('tasks.update-status', ['task' => $task]), $data);

        $response->assertOk()->assertJson($data);
        $this->assertDatabaseHas(Task::class, array_merge($data, ['id' => $task->id]));
    }
}
