<?php

namespace App\Models;

use App\Models\Scopes\CartWithCookieIdScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'cookie_id',
        'user_id',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    protected static function booted()
    {
        self::addGlobalScope('cart_by_cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', Cart::getCookieId());

            if (auth()->check()) {
                $builder->orWhere('user_id', auth()->id());
            }

            return $builder;
        });


        // Could Make observer if there is more event waited
        static::creating(function (Cart $cart) {
            $cart->id = Str::uuid();
        });
    }

    public static function getCookieId(): string
    {
        $cookie_id = Cookie::get('cart');

        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart', $cookie_id, 30 * 24 * 60);
        }

        return $cookie_id;
    }

//    /******************** Scopes *********************/
//
//    public function scopeUsingUserCookieId(Builder $builder): Builder
//    {
//        return $builder->where('cookie_id', Cart::getCookieId());
//    }

    /******************** Relations *******************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
//
//    public function product(): BelongsTo
//    {
//        return $this->belongsTo(Product::class);


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_item', 'cart_id', 'product_id', 'id', 'id')
            ->using(CartItem::class)
            ->as('details')
            ->withPivot(['qty']);
    }



    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }
}
