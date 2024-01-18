<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Review\ReviewStoreRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewStoreRequest $request, Product $product)
    {
//        dd(array_merge($request->validated(), ['user_id' => auth()->id()]));


        $product->reviews()->create(array_merge($request->validated(), ['user_id' => auth()->id()]));

        return to_route('front.products.show', $product);
    }
}
