<?php

namespace App\Observers;

use App\Task;
use Illuminate\Support\Arr;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->recordActivity('created_task');
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        $changes = $this->getChanges($task);
        if ($task->completed && !$task->getOriginal('completed')) 
        {
            $task->recordActivity('completed_task',$changes);
        } else if(!$task->completed && $task->getOriginal('completed'))
        {
            $task->recordActivity('uncompleted_task',$changes);
        }else{
            $task->recordActivity('updated_task',$changes);
        }
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $task->recordActivity('deleted_task');
    }

    /**
     * Handle the task "restored" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
    protected function getChanges(Task $task){
        $after = Arr::except($task->getChanges(),'updated_at');
        $original= $task->getOriginal();

        $before = array_intersect_key($original,$after);
        $changes = 
        ['before'=>$before,
        'after'=>$after];
        return $changes;
    }
}
