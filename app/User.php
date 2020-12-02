<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->hasMany('App\Project', 'owner_id');
    }
    public function getProjects()
    {
       return  Project::where('owner_id', $this->id)
            ->orWherehas('members', function (Builder $query) {
                $query->where('member_id', $this->id);
            })->orderBy('updated_at', 'desc')->get();
        
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function invitedProject()
    {
        return $this->belongsToMany('App\Project', 'member_project', 'member_id', 'project_id');
    }
}
