<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = true;

    protected $table = 'order_items';


    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'qty',
        'price',
        'total',
        'option',
    ];

    protected $casts = [
        'option' => 'array',
    ];

    /**************** Relations ************************/

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
