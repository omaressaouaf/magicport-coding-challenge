<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateTaskStatusController extends Controller
{
    public function __invoke(UpdateTaskStatusRequest $request, Task $task, TaskRepository $taskRepository)
    {
        $taskRepository->updateStatus($task, TaskStatus::from($request->get('status')));

        return new JsonResponse($task->fresh(), Response::HTTP_OK);
    }
}
