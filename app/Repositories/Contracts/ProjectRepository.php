<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ProjectRepository
{
    public function get(): Collection;
}
