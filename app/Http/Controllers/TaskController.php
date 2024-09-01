<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function store(Project $project, StoreUpdateTaskRequest $request)
    {
        $task = $this->taskRepository->create($project, $request->validated());

        return new JsonResponse($task, Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        return new JsonResponse($task);
    }

    public function update(StoreUpdateTaskRequest $request, Task $task)
    {
        $this->taskRepository->update($task, $request->validated());

        return new JsonResponse($task->fresh(), Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        $this->taskRepository->delete($task);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
