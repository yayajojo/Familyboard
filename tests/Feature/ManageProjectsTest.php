<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();
        $this->post(route('project.store'), $project->toArray())->assertRedirect(route('login'));
        $this->get(route('project.index'))->assertRedirect(route('login'));
        $this->get(route('project.show', ['project' => $project]))->assertRedirect(route('login'));
        $this->get(route('project.create'))->assertRedirect(route('login'));
        $this->patch(route('project.update', compact('project')))->assertRedirect(route('login'));
        $this->delete(route('project.destory', compact('project')))->assertRedirect(route('login'));
    }


    /** @test */
    public function an_authenticated_user_can_view_their_project()
    {

        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->get(route('project.show', ['project' => $project]))
            ->assertSee($project->title);
    }

    /** @test */
    public function user_can_view_all_accessible_project()
    {
        $may = factory('App\User')->create();
        $project = ProjectFactory::ownedBy($may)->create();
        $jhon = factory('App\User')->create();
        $project->invite($jhon);
        $this->signIn($jhon);
        $this->get(route('project.index'))->assertSee($project->title);

    }
    
    /** @test */
    public function project_owner_can_update_the_project_note()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $note = ['note' => 'Generate note changed!'];
        $this->patch(route('project.update', compact('project')), $note)
            ->assertRedirect(route('project.show', compact('project')));
        $this->get(route('project.show', compact('project')))->assertSee('Generate note changed!');
        $this->assertDatabaseHas('projects', $note);
    }

    /** @test */
    public function project_owner_can_update_the_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $projectBody = ['title' => 'title changed', 'description' => 'description changed'];
        $this->patch(route('project.update', compact('project')), $projectBody)
            ->assertRedirect(route('project.show', compact('project')));
        $response = $this->get(route('project.show', compact('project')));
        $response->assertSeeText('title changed');
        $this->assertDatabaseHas('projects', $projectBody);
    }
    /** @test */
    public function an_authenticated_user_can_create_a_project()
    {

        $user = $this->signIn();
        $this->get(route('project.create'))->assertStatus(200);
        $attributes = factory('App\Project')->raw(['owner_id' => null, 'note' => null]);
        $authenticatedAttributes = array_merge($attributes, ['owner_id' => $user->id]);
        $this->post(route('project.store'), $attributes)
            ->assertStatus(302);
        $this->get(route('project.index'))->assertSee($attributes['title']);
        $this->assertDatabaseHas('projects', $authenticatedAttributes);
    }

    /** @test */
    public function project_owner_can_delete_the_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->delete(route('project.destory', compact('project')));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
    /** @test */
    public function only_project_owner_can_delete_the_project()
    {
        $this->signIn();
        $project = ProjectFactory::create();
        $this->delete(route('project.destory', compact('project')))->assertForbidden();
        $this->assertDatabaseHas('projects', ['id' => $project->id]);
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
    
    
}
