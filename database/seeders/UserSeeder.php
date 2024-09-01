<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $permissionsNames = [
            'list projects',
            'view project',
            'create task',
            'edit task',
            'delete task',
        ];

        Permission::query()->upsert(
            Arr::map($permissionsNames, fn (string $permissionName) => ['name' => $permissionName]),
            'name'
        );

        $role = Role::query()->create(
            [
                'name' => 'admin',
            ]
        );

        $user = User::query()->create(
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        /**
         * @var PermissionService $permissionService
         */
        $permissionService = app(PermissionService::class);

        $permissionService->syncPermissionsToRole($role, $permissionsNames);

        $permissionService->syncRolesToUser($user, [$role->name]);
    }
}
