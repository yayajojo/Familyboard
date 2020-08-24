<?php

namespace App\Observers;

use App\Activity;
use App\Project;
use Illuminate\Support\Arr;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
       
        $project->recordActivity('created');;
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

    /**
     * Handle the project "deleted" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        
    }

    /**
     * Handle the project "restored" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the project "force deleted" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }

    protected function getChanges(Project $project){
        $after = Arr::except($project->getChanges(),'updated_at');
        $original= $project->getOriginal();
        $before = array_intersect_key($original,$after);
        $changes = 
        ['before'=>$before,
        'after'=>$after];
        return $changes;
    }
}
