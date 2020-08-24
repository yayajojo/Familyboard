<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['body', 'completed'];
    protected $touches = ['project'];
    protected $casts = ['completed' => 'boolean'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function path()
    {
        return '/projects/' . $this->project->id . '/tasks/' . $this->id;
    }
    public function activities()
    {
        return $this->morphMany('App\Activity', 'recordable');
    }
    public function recordActivity(string $description, $changes = null)
    {
        $this->activities()->create(['description' => $description, 'changes' => $changes]);
    }
}
