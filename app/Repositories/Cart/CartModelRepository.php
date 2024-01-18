<?php

namespace App\Repositories\Cart;

use App\Interfaces\Cart\CartRepository;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

//use App\Models\Scopes\CartWithCookieIdScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    protected ?Cart $cart = null;
    protected ?Collection $products = null;

    /**
     *  Return the Cart Instance
     *
     * @return Cart|null
     */
    public function get(): ?Cart
    {
        if (!$this->cart) {
            $this->cart = Cart::select(['id'])
                ->with(
                    [
                        'products' =>
                            [
                                'media'
                            ]
//                      OR
//               fn($query) => $query->select(['id', 'price','slug'])->with('media')

                    ]
                )
                ->
                first();
        }

        return $this->cart;
    }

    /**
     *  Return Cart Products
     *
     * @return Collection|null
     */
    public function products(): ?Collection
    {
        if (!$this->products) {
            $this->products = $this->get()?->products ?? collect();
        }
        return $this->products;
    }


    public function add(Product $product, $qty = 1): void
    {
        $cart = Cart::first();

        if (!$cart) {
            global $cart;
            $cart = Cart::create([
                'cookie_id' => Cart::getCookieId(),
                'user_id' => auth()?->id(),
            ]);
        }

        CartItem::updateOrCreate(
            [
                'product_id' => $product->id,
                'cart_id' => $cart->id,
            ]
            ,
            [
                'qty' => DB::raw('qty + ' . ($qty > 0 ? $qty : 1)),
            ]
        );
    }

    public function update(Product $product, $qty = 1)
    {
        Cart::where('product_id', '=', $product->id)
            ?->update([
                'qty' => $qty > 0 ? $qty : 1
            ]);
    }

    public function delete($id): ?bool
    {
        return Cart::where('id', $id)
            ?->delete();
    }

    public function empty(): ?bool
    {
        return Cart::query()->delete();
    }


    /**
     * Get Cart Total Price
     *
     * @return float
     */
    public function total(): float
    {
//        return (float)Cart::where('cookie_id', $this->getCookieId())
//            ->join('products', 'products.id', '=', 'carts.product_id')
//            ->selectRaw('SUM(products.price * carts.qty) as total')
//            ->value('total');

//        return (float)$this->get()->sum(fn(Cart $cart) => $cart->items->qty * $cart->items->product->price);

//        dd($this->products());
        return (float)$this->products()?->sum(fn(Product $product) => $product->details->qty * $product->price);
    }
}
