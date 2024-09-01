<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Project;
use App\Repositories\Contracts\ProjectRepository;
use App\Repositories\Contracts\TaskRepository;

class ProjectController extends Controller
{
    public function index(ProjectRepository $projectRepository)
    {
        return view('dashboard')->with(
            [
                'projects' => $projectRepository->get(request()->get('name')),
            ]
        );
    }

    public function show(Project $project, TaskRepository $taskRepository)
    {
        return view('project')->with(
            [
                'project' => $project,
                'tasks' => $taskRepository->get($project, TaskStatus::tryFrom(request()->get('status')))
            ]
        );
    }
}
