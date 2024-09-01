<?php

namespace App\Repositories\Contracts;

use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Collection;

interface TaskRepository
{
    public function create(Project $project, array $data): Task;

    public function update(Task $task, array $data): bool;

    public function updateStatus(Task $task, TaskStatus $taskStatus): bool;

    public function delete(Task $task): bool;

    public function get(): Collection;
}
