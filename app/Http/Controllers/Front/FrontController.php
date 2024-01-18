<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class FrontController extends Controller
{
    public function __invoke()
    {
        return view('front.index',
            [
                'products' => Product::active()
                    ->feature()
                    ->select(['id', 'slug', 'category_id', 'price', 'compare_price'])
                    ->withCount('reviews')
                    ->withAvg('reviews','rate')
                    ->with(
                        [
                            'category:id', 'media',
                            'reviews:id,rate'
                        ]
                    )->get()
            ]
        );
    }
}
