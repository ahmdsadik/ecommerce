<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Front extends Component
{

    public function __construct
    (
        public $title,
        public $categories = [],
    )
    {
        $this->categories = Category::parentAndActiveCached();
    }

    public function render(): View
    {
        return view('front.layouts.front');
    }
}
