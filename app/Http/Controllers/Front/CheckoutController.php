<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    public function create()
    {
        if (!Cart::get()) {
            return to_route('front.products.index');
        }

        return view('front.checkout.create',
            [
                'total' => Cart::total()
            ]
        );
    }

    public function store(Request $request)
    {
        // TODO:: Add Validation
        // TODO:: Try to enhance this code
        // TODO:: add all columns when adding order

        try {
            DB::beginTransaction();

            $items = Cart::products()->groupBy('store_id');

            if (!$items->count()) {
                return to_route('front.products.index');
            }

            $order_price = Cart::total();

            $order = Order::create([
                'user_id' => auth()?->id(),
                'total' => $order_price,
                'currency' => session('currency_code', config('app.currency'))
            ]);

            foreach ($items as $store_id => $cart_items) {

                $orderItems = [];

                foreach ($cart_items as $item) {

                    $orderItems[] = [
                        'store_id' => $store_id,
                        'product_id' => $item->id,
                        'order_id' => $order->id,
                        'product_name' => $item->name,
                        'qty' => $item->details->qty,
                        'price' => $item->price,
                        'total' => $item->details->qty * $item->price
                    ];
                }
                OrderItem::insert($orderItems);
            }
            OrderCreated::dispatch($order);

//            $userAdd = [];
//            foreach ($request->post('addr') as $type => $address) {
//                $address['type'] = $type;
////                    $address['order_id'] = $order->id;
////                    $userAdd[] = $address;
//                $order->addresses()->create($address);
//            }

//                $order->addresses()->insert($userAdd);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return to_route('front.payment.create', $order);
    }
}
