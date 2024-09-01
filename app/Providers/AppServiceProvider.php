<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
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
