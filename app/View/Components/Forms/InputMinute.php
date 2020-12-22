<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputMinute extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $name;

    public $title;

    public function __construct($title, $name)
    {
        $this->title = $title;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.input-minute');
    }
}
