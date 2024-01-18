<?php

namespace App\Models;

use App\Enums\OrderAddressTypes;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
//        'store_id',
        'user_id',
        'number',
        'status',
        'total',
        'currency'
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];


    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = self::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = now()->year;
        $number = self::whereYear('created_at', now()->year)->max('number');
        if ($number) {
            return $number + 1;
        }

        return $year . '0001';
    }


    /********************** Relations ***************************/

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_details')
            ->withPivot(['product_name', 'qty', 'price','total', 'option']);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class,'order_items','order_id','store_id','id','id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function billingAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', OrderAddressTypes::BILLING);
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', OrderAddressTypes::SHIPPING);
    }
}
