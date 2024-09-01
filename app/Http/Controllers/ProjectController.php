<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Project;
use App\Repositories\Contracts\ProjectRepository;
use App\Repositories\Contracts\TaskRepository;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function index(ProjectRepository $projectRepository)
    {
        Gate::authorize('has-permission', 'list projects');

        return view('dashboard')->with(
            [
                'projects' => $projectRepository->get(request()->get('name')),
            ]
        );
    }

    public function show(Project $project, TaskRepository $taskRepository)
    {
        Gate::authorize('has-permission', 'view project');

        return view('project')->with(
            [
                'project' => $project,
                'tasks' => $taskRepository->get($project, TaskStatus::tryFrom(request()->get('status')))
            ]
        );
    }
}
