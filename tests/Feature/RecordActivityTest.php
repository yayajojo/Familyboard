<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $project = ProjectFactory::create();
        $project->update(['title' => 'title changed']);
        $this->assertCount(2, $project->activities);
        $project->activities[1]->description = 'updated';
    }

    /** @test */
    public function creating_a_task_()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $this->assertCount(2, $project->activities);
        $this->assertEquals('created_task', $project->activities[1]->description);
    }
    /** @test */
    public function completing_a_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
        $this->patch($project->tasks[0]->path(), ['body' => 'thx', 'completed' => 'on']);
        $this->assertDatabaseHas('activities', ['description' => 'completed_task']);
        $this->assertCount(3, $project->activities);
        $this->assertEquals('completed_task', $project->activities[2]->description);
    }
    /** @test */
    public function uncompleting_a_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
        $this->patch($project->tasks[0]->path(), ['body' => 'body', 'completed' => 'on']);
        $this->assertDatabaseHas('activities', ['description' => 'completed_task']);
        $this->patch($project->tasks[0]->path(), ['body' => 'body changed!']);
        $this->assertCount(4, $project->activities);
        $this->assertEquals('uncompleted_task', $project->activities[3]->description);
    }
    /** @test */
    public function updating_a_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();
        $this->patch($project->tasks[0]->path(), ['body' => 'body changed!']);
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
