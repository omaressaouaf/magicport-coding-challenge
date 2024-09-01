<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentProjectRepository implements ProjectRepository
{
    public function get(?string $name = null): Collection
    {
        return Project::query()
            ->when($name, fn (Builder $query) => $query->where('name', 'LIKE', '%'.$name.'%'))
            ->get();
    }
}
