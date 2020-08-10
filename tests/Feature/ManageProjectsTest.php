<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();
        $this->post(route('project.store'), $project->toArray())->assertRedirect(route('login'));
        $this->get(route('project.index'))->assertRedirect(route('login'));
        $this->get(route('project.show',['project'=>$project]))->assertRedirect(route('login'));
        $this->get(route('project.create'))->assertRedirect(route('login'));
    }

    
    /** @test */
    public function an_authenticated_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();
        $user = $this->authenticateUser();
        $project = factory('App\Project')->create(['owner_id' => $user->id]);
        $this->get(route('project.show', ['project' => $project]))
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->authenticateUser();
        $project = factory('App\Project')->create();
        $this->get(route('project.show', ['project' => $project]))->assertStatus(403);
    }

    /** @test */
    public function a_project_require_a_title()
    {
        $this->authenticateUser();
        $attributes = factory('App\Project')->raw(['title' => null]);
        $this->post(route('project.store'), $attributes)->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_project_require_a_description()
    {

        $this->authenticateUser();
        $attributes = factory('App\Project')->raw(['description' => null]);
        $this->post(route('project.store'), $attributes)->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function an_authenticated_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $user = $this->authenticateUser();
        $this->get(route('project.create'))->assertStatus(200);
        $attributes = factory('App\Project')->raw(['owner_id' => null]);
        $authenticatedAttributes = array_merge($attributes, ['owner_id' => $user->id]);
        $this->post(route('project.store'), $attributes)->assertRedirect('/projects');;
        $this->assertDatabaseHas('projects', $authenticatedAttributes);
        $this->get(route('project.index'))->assertSee($attributes['title']);
    }

    
    protected function authenticateUser()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);
        return $user;
    }
}
