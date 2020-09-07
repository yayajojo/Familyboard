<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Recordability;
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
    public function members()
    {
        return $this->belongsToMany('App\User','member_project','project_id','member_id');
    }
    public function invite(User $member)
    {
       
        MemberProject::firstOrCreate([
            'member_id'=>$member->id,
            'project_id'=>$this->id
            ]);

    }
}
