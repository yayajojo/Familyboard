<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Gravartar extends Component
{
    public $project;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.gravartar');
    }
}
