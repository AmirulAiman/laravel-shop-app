<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class navigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cartCount = 0;
        if(Auth::check()){
            $cartCount = Auth::user()->cart?->items()->count() ?? 0;
        }
        return view('layouts.navigation',compact('cartCount'));
    }
}
