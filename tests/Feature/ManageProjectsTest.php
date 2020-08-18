<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\Setup\ProjectFactory as SetupProjectFactory;
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
        $this->get(route('project.show', ['project' => $project]))->assertRedirect(route('login'));
        $this->get(route('project.create'))->assertRedirect(route('login'));
        $this->patch(route('project.update', compact('project')))->assertRedirect(route('login'));
    }


    /** @test */
    public function an_authenticated_user_can_view_their_project()
    {

        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->get(route('project.show', ['project' => $project]))
            ->assertSee($project->title);
    }
    /** @test */
    public function project_can_update_a_generate_note()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->patch(route('project.update', compact('project')), ['note' => 'Generate note changed!'])
            ->assertRedirect(route('project.show', compact('project')));
        $this->get(route('project.show', compact('project')))->assertSee('Generate note changed!');
    }
    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->signIn();
        $project = ProjectFactory::create();
        $this->get(route('project.show', ['project' => $project]))->assertStatus(403);
    }
    /** @test */
    public function an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->signIn();
        $project = ProjectFactory::create();
        $this->patch(route('project.update', ['project' => $project]))->assertStatus(403);
    }
    /** @test */
    public function a_project_require_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['title' => null]);
        $this->post(route('project.store'), $attributes)->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_project_require_a_description()
    {

        $this->signIn();
        $attributes = factory('App\Project')->raw(['description' => null]);
        $this->post(route('project.store'), $attributes)->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function an_authenticated_user_can_create_a_project()
    {
        
        $user = $this->signIn();
        $this->get(route('project.create'))->assertStatus(200);
        $attributes = factory('App\Project')->raw(['owner_id' => null,'note'=>null]);
        $authenticatedAttributes = array_merge($attributes, ['owner_id' => $user->id]);
        $this->post(route('project.store'), $attributes)
            ->assertStatus(302);
        $this->get(route('project.index'))->assertSee($attributes['title']);
        $this->assertDatabaseHas('projects', $authenticatedAttributes);
    }
}
