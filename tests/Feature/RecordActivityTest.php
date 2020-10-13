<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities[0]->description);
    }
    /**
     * @test
     */
    public function updating_a_project()
    {
        $project = factory('App\Project')->create(['title'=>'title']);
        $project->update(['title' => 'title changed']);
        $this->assertCount(2, $project->activities);
        $this->assertDatabaseHas('activities', [
            'recordable_type' => 'App\Project',
            'recordable_id' => $project->id,
            'description' => 'updated',
        ]);
        
        $this->assertEquals(['after'=>['title'=>'title changed'],'before'=>['title'=>'title']],
        $project->activities[1]->changes);
    }

    /** @test */
    public function creating_a_task_()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $task = $project->tasks[0];
        $this->assertCount(1, $project->activities);
        $this->assertCount(1, $task->activities);
        $this->assertEquals('created_task', $task->activities[0]->description);
    }
    /** @test */
    public function completing_a_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
        $task = $project->tasks[0];
        $completedTask = array_merge($task->toArray(),['completed' => 'on']);
        $this->patch($task->path(), $completedTask);
        $this->assertDatabaseHas('activities', ['description' => 'completed_task']);
        $this->assertCount(2, $task->activities);
        $this->assertEquals('completed_task', $task->activities[1]->description);
        $this->assertEquals(['after'=>['completed'=>true],'before'=>['completed'=>false]],
        $task->activities[1]->changes);
    }
    /** @test */
    public function uncompleting_a_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
        $task = $project->tasks[0];
        $completedTask = array_merge($task->toArray(),['completed' => 'on']);
        $this->patch($task->path(), $completedTask);
        $this->assertDatabaseHas('activities', ['description' => 'completed_task']);
        $uncompletedTask = Arr::except($completedTask,'completed');
        $this->patch($task->path(), $uncompletedTask);
        $this->assertCount(1, $project->activities);
        $this->assertCount(3, $task->activities);
        $this->assertEquals('uncompleted_task', $task->activities[2]->description);
        $this->assertEquals(['after'=>['completed'=>false],'before'=>['completed'=>true]],
        $task->activities[2]->changes);
    }
    /** @test */
    public function updating_a_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
        $task = $project->tasks[0];
        $updatedTask = Arr::except(array_merge($task->toArray(),['body' => 'body changed!']),'completed');
        $this->patch($task->path(), $updatedTask);
        $this->assertDatabaseHas('activities', ['description' => 'updated_task']);
    }
    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
        $project->tasks()->first()->delete();
        $this->assertDatabaseHas('activities', ['description' => 'deleted_task']);
    }
}
