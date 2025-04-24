<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class NavigationAuth extends Component
{
    public $user;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
        $this->user = Auth::check() ? Auth::user(): null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation-auth');
    }
}
