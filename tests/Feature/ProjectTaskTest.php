<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
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
}
