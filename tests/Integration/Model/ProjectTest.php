<?php

namespace Tests\Integration\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function a_project_belongs_to_an_owner()
    {
     $project = factory('App\Project')->create();
     $this->assertInstanceOf('App\User',$project->owner);
    }
    /** @test */
    public function project_can_add_a_project()
    {
        $project = factory('App\Project')->create();
        $task = factory('App\Task')->create(['project_id'=>$project->id]);
        $project->tasks()->save($task);
        $this->assertDatabaseHas('tasks',
        ['project_id'=>$project->id,
         'body'=>$task->body
        ]);
    }
    
}
