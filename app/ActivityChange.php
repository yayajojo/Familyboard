<?php
namespace App;
use Illuminate\Support\Arr;

trait ActivityChange
{
    protected function getChanges($recordable){
        $after = Arr::except($recordable->getChanges(),'updated_at');
        $original= $recordable->getOriginal();
        $before = array_intersect_key($original,$after);
        $changes = 
        ['before'=>$before,
        'after'=>$after];
        return $changes;
    }
}