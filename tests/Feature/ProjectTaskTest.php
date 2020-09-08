<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\SetUp\ProjectFactory;
use Illuminate\Support\Arr;
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
    $task = factory('App\Task')->raw(['project_id' =>null,
    'body'=>'Task test',
    'assignee_id'=>$project->owner_id]);
    
    $this->post(
      route('task.store', ['project' => $project]),
      $task
    );
    $this->get(route('project.show', ['project' => $project]))->assertSee('Task test');
  }

  /** 
   * @test
   * 
   */
  public function a_task_can_be_updated()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
    $task = $project->tasks[0];
    $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    $updatedTask = array_merge($task->toArray(),['body' => 'Task updated']);
    $this->patch($task->path(), $updatedTask)
    ->assertRedirect(route('project.show', ['project' => $project]));
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
  public function only_project_members_can_update_project_tasks()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $task = factory('App\Task')->create();
    $this->patch($task->path(), ['body' => 'Test task'])
      ->assertStatus(403);
    $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
  }
  /** @test */
  public function only_project_members_can_see_edit_task_page()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $task = factory('App\Task')->create();
    $this->get(route('task.edit',['project'=>$project,'task'=>$task]))->assertStatus(403);
  }
  /** @test */
  public function updated_task_would_be_redirected()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
    $task = $project->tasks->first();
    $updatedTask = array_merge($task->toArray(),['body'=>'task changed']);
    $this->patch($task->path(),$updatedTask)
    ->assertRedirect(route('project.show',compact('project')));
  }
  
  /** @test */
  public function a_task_require_a_due_date()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $this->post(route('task.store', ['project' => $project]), ['body' => "no due date",'due'=>null])
      ->assertSessionHasErrors(['due']);
  }

  /** @test */
  public function a_task_require_a_start_date()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $this->post(route('task.store', ['project' => $project]), ['body' => "no due date",'due'=>Carbon::now(),'start'=>null])
      ->assertSessionHasErrors(['start']); 
  }

  /** @test */
  public function a_task_require_an_assignee()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $task = factory('App\Task')->raw(['assignee_id'=>null,'project_id'=>null]);
    $this->post(route('task.store', ['project' => $project]), $task)
      ->assertSessionHasErrors(['assignee_id']);
  }
  
  
  
  

  /** @test */
  public function a_task_require_a_body()
  {
    $project = ProjectFactory::ownedBy($this->signIn())->create();
    $this->post(route('task.store', ['project' => $project]), ['body' => null])
      ->assertSessionHasErrors(['body']);
  }
  
  
  
}
