<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navbar extends Component
{
public $empresa;

    public function __construct($empresa = null)
    {
        $this->empresa = $empresa;
    }

    public function render()
    {
        return view('components.navbar');
    }
}
