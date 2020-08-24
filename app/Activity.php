<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable=['description','changes'];
    protected $casts = ['changes' => 'array'];

    public function recordable()
    {
        return $this->morphTo();
    }
}
