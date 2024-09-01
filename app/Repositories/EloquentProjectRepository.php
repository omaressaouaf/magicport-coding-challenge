<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepository;
use Illuminate\Support\Collection;

class EloquentProjectRepository implements ProjectRepository
{
    public function create(array $data): Project
    {
        /**
         * @var Project $project
         */
        $project = Project::query()->create($data);

        return $project;
    }

    public function update(Project $project, array $data): bool
    {
        return $project->update($data) != 0;
    }

    public function delete(Project $project): bool
    {
        return $project->delete() != 0;
    }

    public function findById(int $id): ?Project
    {
        /**
         * @var Project $project
         */
        $project = Project::query()->find($id);

        return $project;
    }

    public function get(): Collection
    {
        return Project::query()->get();
    }
}
