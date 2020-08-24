<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['note', 'title', 'description', 'owner_id'];
    

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }


    public function addTask(array $task)
    {
        $this->tasks()->create($task);
    }

    public function activities()
    {
        return $this->morphMany('App\Activity', 'recordable');
    }

    public function recordActivity(string $description, $changes = null)
    {
        $this->activities()->create(
            [
                'description' => $description,
                'changes' => $changes
            ]
        );
    }
}
