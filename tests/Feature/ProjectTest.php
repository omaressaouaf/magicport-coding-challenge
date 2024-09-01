<?php

namespace Tests\Feature;

use App\Models\Project;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    protected bool $authenticated = true;

    public function test_projects_can_be_listed(): void
    {
        $projects = Project::factory()->count(4)->create();

        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard');
        $response->assertViewHas('projects', $projects);
        $response->assertSee($projects->first()->name);
    }

    public function test_projects_can_be_searched(): void
    {
        $firstProject = Project::factory()->create(['name' => 'first project']);
        $secondProject = Project::factory()->create(['name' => 'second project']);

        $response = $this->get(route('dashboard', ['name' => 'first']));

        $response->assertSee($firstProject->name);
        $response->assertDontSee($secondProject->name);
    }
}
