<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class PermissionService
{
    public function syncPermissionsToRole(Role $role, array $permissionsNames): void
    {
        $permissionsIds = count($permissionsNames)
            ? Permission::query()->whereIn('name', $permissionsNames)->get()->pluck('id')
            : [];

        $role->permissions()->sync($permissionsIds);
    }

    public function syncRolesToUser(User $user, array $rolesNames): void
    {
        $rolesIds = count($rolesNames)
            ? Role::query()->whereIn('name', $rolesNames)->get()->pluck('id')
            : [];

        $user->roles()->sync($rolesIds);
    }

    public function userHasPermission(User $user, string $permissionName): bool
    {
        $userPermissionsNames = $user
            ->roles
            ->map
            ->permissions
            ->flatten()
            ->pluck('name')
            ->toArray();

        return in_array($permissionName, $userPermissionsNames);
    }
}
