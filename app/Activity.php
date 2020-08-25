<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable=['description','changes','user_id'];
    protected $casts = ['changes' => 'array'];

    public function recordable()
    {
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }


}
