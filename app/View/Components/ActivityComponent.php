<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActivityComponent extends Component
{
    public $activity;
    public $action;
    public $mission;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($activity,$action,$mission)
    {
        $this->activity = $activity;
        $this->action = $action;
        $this->mission = $mission;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.activity-component');
    }
}
