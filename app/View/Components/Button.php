<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public string $type;
    public string $btnName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $type, string $btnName)
    {
        $this->type = $type;
        $this->btnName = $btnName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
