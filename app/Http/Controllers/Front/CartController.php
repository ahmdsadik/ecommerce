<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\Cart\CartRepository;
use App\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
//    public function __construct(public CartRepository $cart)
//    {
//    }

    public function index()
    {

//        return  Order::first()->items()->sum(DB::raw('qty * price'));
//        return  Order::first()->items->sum(fn(OrderItem $orderItem) => $orderItem->qty * $orderItem->price);

        return view('front.cart.index',
            [
                'cart' => Cart::products(),
                'total' => Cart::total()
            ]
        );
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'min:1|integer|nullable'
        ]);

        try {
           Cart::add($product, $request->post('qty'));
        }catch (\Exception $exception){
//            dd($exception);
            return to_route('front.products.index');
        }
        return to_route('front.cart.index');
    }


    public function update(Request $request, Cart $cart)
    {
    }

    public function destroy(Request $request, $id)
    {
        Cart::delete($id);
    }
}
