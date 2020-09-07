<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberProject extends Model
{
    protected $table = 'member_project';
    protected $fillable = ['member_id','project_id'];

}
