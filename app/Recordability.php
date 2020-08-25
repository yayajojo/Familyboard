<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait Recordability
{
    public function recordActivity(string $description, $changes = [])
    {
        $user_id = $this->activityOwner();// used for temporary purposes to pass tests 
        $this->activities()->create(['user_id'=>$user_id,'description' => $description, 'changes' => $changes]);
    }

   protected function activityOwner()
   {
       if(Auth::check()){
           return Auth::id();
       }
       if(class_basename($this) === 'Project'){
        return $this->owner->id;
       }elseif(class_basename($this) === 'Task'){
        return $this->project->owner->id;
       }
           
   }
}
