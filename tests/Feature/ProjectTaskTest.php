<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
  use RefreshDatabase;
  public function guests_cannot_manage_tasks()
  {
    $project = factory('App\Project')->create();
    $task = ['body' => 'gogo'];
    $this->post(route('task.store', ['project' => $project]), $task)
      ->assertRedirect(route('login'));
  }
  /** @test */
  public function project_can_has_tasks()
  {
    $user = $this->authenticateUser();
    $project = factory('App\Project')->create(['owner_id' => $user->id]);
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
    $user = $this->authenticateUser();
    $project = factory('App\Project')->create(['owner_id'=>$user->id]);
    $task = factory('App\Task')->create(['project_id'=>$project->id]);
    $this->assertDatabaseHas('tasks',['id'=>$task->id]);
    $this->patch($task->path(), ['completed'=>'on','body' => 'Task updated'])->assertRedirect(route('project.show',['project'=>$project]));
    $this->assertDatabaseHas('tasks',['body' => 'Task updated','completed'=>true,'id'=>$task->id]);
  }

  /** @test */
  public function only_project_owner_can_add_project_tasks()
  {
    $this->authenticateUser();
    $project = factory('App\Project')->create();
    $this->post(route('task.store', ['project' => $project]), ['body' => 'Test task'])
      ->assertStatus(403);
    $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
  }

  /** @test */
  public function only_task_owner_can_update_project_tasks()
  {
    $user = $this->authenticateUser();
    $project = factory('App\Project')->create(['owner_id'=>$user->id]);
    $task = factory('App\Task')->create();
    $this->patch('/projects/'.$project->id.'/tasks/'.$task->id, ['body' => 'Test task'])
      ->assertStatus(403);
    $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
  }

  /** @test */
  public function a_task_require_a_body()
  {
    $user = $this->authenticateUser();
    $project = factory('App\Project')->create(['owner_id' => $user->id]);
    $this->post(route('task.store', ['project' => $project]), ['body' => null])
      ->assertSessionHasErrors(['body']);
  }
}
