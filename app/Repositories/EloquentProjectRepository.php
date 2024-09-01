<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepository;
use Illuminate\Support\Collection;

class EloquentProjectRepository implements ProjectRepository
{
    public function get(): Collection
    {
        return Project::query()->get();
    }
}
