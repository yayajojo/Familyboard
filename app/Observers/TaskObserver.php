<?php

namespace App\Observers;

use App\ActivityChange;
use App\Events\TasksChanged;
use App\Task;


class TaskObserver
{
    use ActivityChange;
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->recordActivity('created_task');
        //broadcast(new TasksChanged($task->project));
        
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
        if ($this->isCompleted($task)) {
            $task->recordActivity('completed_task', $changes);
        } else if ($this->isUncompleted($task)) {
            $task->recordActivity('uncompleted_task', $changes);
        } else {
            $task->recordActivity('updated_task', $changes);
        }
        //new TasksChanged($task->project));

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

    protected function isCompleted(Task $task)
    {
        return $task->completed && !$task->getOriginal('completed');
    }
    protected function isUncompleted(Task $task)
    {
        return !$task->completed && $task->getOriginal('completed');
    }


}
