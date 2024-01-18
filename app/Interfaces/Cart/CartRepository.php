<?php

namespace App\Interfaces\Cart;

use App\Models\Cart;
use App\Models\Product;

interface CartRepository
{
    public function get();

    public function add(Product $product, $qty = 1);
    public function update(Product $product,$qty=1);
    public function delete($id);
    public function empty();
    public function total():float;

}
