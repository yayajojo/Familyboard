<?php

namespace App\Observers;

use App\ActivityChange;
use App\Events\UpdateProject;
use App\Project;


class ProjectObserver
{
    use ActivityChange;
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
       
        $project->recordActivity('created');

    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $changes =$this->getChanges($project);
        $project->recordActivity('updated',$changes);
    }

}
