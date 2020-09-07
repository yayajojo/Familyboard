<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Facades\Tests\SetUp\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /** @test */
    public function task_date_is_formated_correct()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();
        $task = $project->tasks[0];
        $task->due = '2020-09-12 17:00:00';
        $task->save();
        $formatedDue= Carbon::parse($task->due)->format('Y-m-d\TH:i');
        $this->assertEquals($formatedDue,'2020-09-12T17:00');
        
    }
}
