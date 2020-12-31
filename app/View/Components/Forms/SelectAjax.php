<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class SelectAjax extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $title;

    public $name;

    public $multiple;

    public function __construct($title, $name, $multiple = false)
    {
        $this->title = $title;
        $this->name = $name;
        $this->multiple = $multiple;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.select-ajax');
    }
}
