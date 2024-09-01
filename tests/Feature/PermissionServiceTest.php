<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\PermissionService;
use Tests\TestCase;

class PermissionServiceTest extends TestCase
{
    protected PermissionService $permissionService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->permissionService = app(PermissionService::class);
    }

    public function test_permissions_can_be_synced_to_role(): void
    {
        $firstPermission = Permission::query()->create(['name' => 'first permission']);
        $secondPermission = Permission::query()->create(['name' => 'second permission']);
        $thirdPermission = Permission::query()->create(['name' => 'third permission']);

        $role = Role::query()->create(['name' => 'first role']);

        $this->permissionService->syncPermissionsToRole($role, [$firstPermission->name, $secondPermission->name]);

        $this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_id' => $firstPermission->id]);
        $this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_id' => $secondPermission->id]);
        $this->assertDatabaseMissing('permission_role', ['role_id' => $role->id, 'permission_id' => $thirdPermission->id]);
    }

    public function test_roles_can_be_synced_to_user(): void
    {
        $firstRole = Role::query()->create(['name' => 'first role']);
        $secondRole = Role::query()->create(['name' => 'second role']);
        $thirdRole = Role::query()->create(['name' => 'third role']);

        $user = User::factory()->create();

        $this->permissionService->syncRolesToUser($user, [$firstRole->name, $secondRole->name]);

        $this->assertDatabaseHas('role_user', ['user_id' => $user->id, 'role_id' => $firstRole->id]);
        $this->assertDatabaseHas('role_user', ['user_id' => $user->id, 'role_id' => $secondRole->id]);
        $this->assertDatabaseMissing('role_user', ['user_id' => $user->id, 'role_id' => $thirdRole->id]);
    }

    public function test_user_has_permission_check(): void
    {
        $firstPermission = Permission::query()->create(['name' => 'first permission']);
        $secondPermission = Permission::query()->create(['name' => 'second permission']);
        $role = Role::query()->create(['name' => 'first role']);
        $user = User::factory()->create();

        $this->permissionService->syncPermissionsToRole($role, [$firstPermission->name]);
        $this->permissionService->syncRolesToUser($user, [$role->name]);

        $this->assertTrue($this->permissionService->userHasPermission($user, $firstPermission->name));
        $this->assertFalse($this->permissionService->userHasPermission($user, $secondPermission->name));
    }
}
