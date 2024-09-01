<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function store(Project $project, StoreUpdateTaskRequest $request)
    {
        Gate::authorize('has-permission', 'create task');

        $task = $this->taskRepository->create($project, $request->validated());

        return new JsonResponse($task, Response::HTTP_CREATED);
    }

    public function update(StoreUpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('has-permission', 'edit task');

        $this->taskRepository->update($task, $request->validated());

        return new JsonResponse($task->fresh(), Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        Gate::authorize('has-permission', 'delete task');

        $this->taskRepository->delete($task);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
