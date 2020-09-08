<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use Recordability;

    protected $fillable = ['body', 'completed','start','due','assignee_id'];
    protected $touches = ['project'];
    protected $casts = [
        'completed' => 'boolean',
        'start'=>'datetime:Y-m-d H:i',
        'due'=>'datetime:Y-m-d H:i'
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function assignee()
    {
        return $this->belongsTo('App\User','assignee_id');
    }
    public function path()
    {
        return '/projects/' . $this->project->id . '/tasks/' . $this->id;
    }
    public function activities()
    {
        return $this->morphMany('App\Activity', 'recordable');
    }


}
