<?php

namespace App\View\Components;

use App\Facades\Cart;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartMenu extends Component
{

    public function __construct(
        public $items = [],
        public $total = 0
    )
    {
        $this->items = Cart::products();
        $this->total = Cart::total();
    }

    public function render(): View
    {
        return view('front.components.cart-menu');
    }
}
