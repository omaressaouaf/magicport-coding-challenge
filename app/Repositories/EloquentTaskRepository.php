<?php

namespace App\Repositories;

use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentTaskRepository implements TaskRepository
{
    public function create(Project $project, array $data): Task
    {
        /**
         * @var Task $task
         */
        $task = Task::query()->create(array_merge($data, ['project_id' => $project->id]));

        return $task;
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data) != 0;
    }

    public function updateStatus(Task $task, TaskStatus $status): bool
    {
        return $task->update(['status' => $status]) != 0;
    }

    public function delete(Task $task): bool
    {
        return $task->delete() != 0;
    }

    public function get(Project $project, ?TaskStatus $status = null): Collection
    {
        return $project
            ->tasks()
            ->when($status, fn (Builder $query) => $query->where('status', $status))
            ->get();
    }
}
