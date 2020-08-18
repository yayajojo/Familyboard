<?php

namespace Tests\Setup;

use App\User;

class ProjectFactory
{
    protected $taskCount;
    protected $user;
    public function ownedBy(User $user)
    {
        $this->user = $user;
        return $this;
    }
    public function withTasks(int $taskCount)
    {
        $this->taskCount = $taskCount;
        return $this;
    }
    public function create()
    {
        $project = factory('App\Project')
            ->create(['owner_id' => $this->user ?? factory('App\User')]);
        if ($this->taskCount) {
            factory('App\Task', $this->taskCount)
                ->create(['project_id' => $project->id]);
        }

        return $project;
    }
}
