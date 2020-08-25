<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\SetUp\ProjectFactory;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
  use RefreshDatabase;
  public function guests_cannot_manage_tasks()
  {
    $project = ProjectFactory::create();
    $task = ['body' => 'gogo'];
    $this->post(route('task.store', ['project' => $project]), $task)
      ->assertRedirect(route('login'));
  }
  /** @test */
  public function project_can_has_tasks()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $task = ['body' => 'Test Task'];
    $this->post(
      route('task.store', ['project' => $project]),
      $task
    );
    $this->get(route('project.show', ['project' => $project]))->assertSee('Test Task');
  }

  /** 
   * @test
   * 
   */
  public function task_can_be_updated()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
    $task = $project->tasks[0];
    $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    $this->patch($task->path(), ['completed' => 'on', 'body' => 'Task updated'])->assertRedirect(route('project.show', ['project' => $project]));
    $this->assertDatabaseHas('tasks', ['body' => 'Task updated', 'completed' => true, 'id' => $task->id]);
  }

  /** @test */
  public function only_project_owner_can_add_project_tasks()
  {
    $this->signIn();
    $project = ProjectFactory::create();
    $this->post(route('task.store', ['project' => $project]), ['body' => 'Test task'])
      ->assertStatus(403);
    $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
  }

  /** @test */
  public function only_task_owner_can_update_project_tasks()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $task = factory('App\Task')->create();
    $this->patch($task->path(), ['body' => 'Test task'])
      ->assertStatus(403);
    $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
  }
  

  /** @test */
  public function a_task_require_a_body()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $this->post(route('task.store', ['project' => $project]), ['body' => null])
      ->assertSessionHasErrors(['body']);
  }
}
