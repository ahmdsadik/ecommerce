<?php

namespace App\Http\Controllers\Front;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductController extends Controller
{
    public function index()
    {

//         dd(Cart::products());

//        return Cart::get()->groupBy('store_id');

//        return \App\Models\Cart::with([
//            'products:id,store_id'
//        ])->first()->products->groupBy('store_id');


//        return \App\Models\Cart::with('items')->first()->items->groupBy('product.store_id');
//
//
//        return \App\Models\Cart::with('items')->first()->items->sum(function (CartItem $cartItem) {
//            return $cartItem->product->price * $cartItem->qty;
//        });
//
//        return \App\Models\Cart::with('products')->first()->products->sum(function (Product $product) {
//            return $product->details->qty * $product->price;
//        });

        return view('front.product.index',
            [
                'products' => Product::active()
                    ->withCount('reviews')
                    ->withAvg('reviews', 'rate')
                    ->with(
                        [
                            'category:id', 'media',
                            'reviews:id,rate'
                        ]
                    )
                    ->take(15)
                    ->get()
            ]
        );
    }

    public function show(Product $product)
    {

//        return $product->reviews->groupBy('rate');
        $product->increment('viewed');
        $product = $product->load(
            [
                'reviews' => ['user:id,name']
            ]
        );
        $revByRate = $product->reviews->groupBy('rate');

        $revCount = $revByRate->map(fn($reviews, $rate) => $reviews->count());

        return view('front.product.show',
            [
                'revCount' => $revCount,
                'product' => $product->load(
                    [
                        'category:id',
                    ]
                )->loadAvg('reviews', 'rate')
            ]
        );
    }
}
