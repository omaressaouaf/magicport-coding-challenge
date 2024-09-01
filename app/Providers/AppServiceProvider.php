<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use App\Repositories\Contracts\ProjectRepository;
use App\Repositories\Contracts\TaskRepository;
use App\Repositories\EloquentProjectRepository;
use App\Repositories\EloquentTaskRepository;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->instance(ProjectRepository::class, new EloquentProjectRepository());
        $this->app->instance(TaskRepository::class, new EloquentTaskRepository());
    }

    public function boot(): void
    {
        $permissionsNames = Cache::rememberForever('permissions', fn() => Permission::all()->pluck('name'));

        foreach ($permissionsNames as $permissionName) {
            Gate::define($permissionName, function (User $user) use ($permissionName) {
                /**
                 * @var PermissionService $permissionService
                 */
                $permissionService = $this->app->make(PermissionService::class);

                return $permissionService->userHasPermission($user, $permissionName);
            });
        }
    }
}
