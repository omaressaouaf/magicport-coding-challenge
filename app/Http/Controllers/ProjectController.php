<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepository;

class ProjectController extends Controller
{
    public function index(ProjectRepository $projectRepository)
    {
        return view('dashboard')->with(
            [
                'projects' => $projectRepository->get()
            ]
        );
    }

    public function show(Project $project)
    {
        return view('project')->with(
            [
                'project' => $project->load('tasks')
            ]
        );
    }
}
