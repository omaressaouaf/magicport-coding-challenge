<?php

namespace Tests;

use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected bool $authenticated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->authenticated) {
            /**
             * @var User $user
             */
            $user = User::factory()->create();

            $this->actingAs($user);

            /**
             * @var PermissionService $permissionService
             */
            $permissionService = app(PermissionService::class);

            $permissionService->syncRolesToUser($user, ['admin']);
        }
    }
}
