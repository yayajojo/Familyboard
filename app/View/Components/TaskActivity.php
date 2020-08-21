<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TaskActivity extends Component
{
    public $activity;
    public $action;
    
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($activity,$action)
    {
        $this->activity = $activity;
        $this->action = $action;
        
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.task-activity');
    }
}
