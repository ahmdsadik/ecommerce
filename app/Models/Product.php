<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements TranslatableContract, HasMedia
{
    use HasFactory, Translatable, InteractsWithMedia, SoftDeletes;

    // TODO:: Add qty and in_stock

    protected $fillable = [
        'slug',
        'store_id',
        'category_id',
        'status',
        'price',
        'compare_price',
        'qty',
        'options',
        'viewed',
        'rating',
        'feature'
    ];

    public array $translatedAttributes = ['name', 'description', 'short_description'];

    protected $with = ['translations'];


    protected $casts = [
        'options' => 'array',
        'status' => ProductStatus::class
    ];

    public function getReadableStatusAttribute(): string
    {
        return match ($this->status) {
            ProductStatus::ACTIVE => __('dashboard/status.active'),
            ProductStatus::INACTIVE => __('dashboard/status.inactive'),
            ProductStatus::DRAFT => __('dashboard/status.draft'),
            default => __('dashboard/status.un_known')
        };
    }


    public static function statusValues(): array
    {
        return [
            ProductStatus::ACTIVE->value => __('dashboard/status.active'),
            ProductStatus::INACTIVE->value => __('dashboard/status.inactive'),
            ProductStatus::DRAFT->value => __('dashboard/status.draft'),
        ];
    }

    /****************** Media **************************/
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->useFallbackUrl(asset('assets/dashboard/default/category/categories.png'))
            ->useDisk('products')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg', 'image/jpg'])
//            ->registerMediaConversions(function (Media $media){
//
//            })
        ;
    }

    /****************** Scopes ************************/

    public function scopeFeature($query)
    {
        return $query->whereFeature(1);
    }

    public function scopeFeatureCachedCount(): int
    {
        return Cache::rememberForever('products_featured_count', fn() => self::whereFeature(1)->count());
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(ProductStatus::ACTIVE);
    }

    public function scopeActiveCachedCount(): int
    {
        return Cache::rememberForever('products_active_count', fn() => self::whereStatus(ProductStatus::ACTIVE)->count());
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(ProductStatus::INACTIVE);
    }

    public function scopeInactiveCachedCount(): int
    {
        return Cache::rememberForever('products_inactive_count', fn() => self::whereStatus(ProductStatus::INACTIVE)->count());
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(ProductStatus::DRAFT);
    }

    public function scopeDraftCachedCount(): int
    {
        return Cache::rememberForever('products_draft_count', fn() => self::whereStatus(ProductStatus::DRAFT)->count());
    }


    public function scopeArchiveCachedCount(): int
    {
        return Cache::rememberForever('products_archive_count', fn() => self::onlyTrashed()->count());
    }

    public function scopeCachedCount(): int
    {
        return Cache::rememberForever('products_count', fn() => self::withTrashed()->count());
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => null
        ], $filters);

        $query->when($options['store_id'], function (Builder $query, $value) {
            $query->where('store_id', $value);
        });

        $query->when($options['category_id'], function (Builder $query, $value) {
            $query->where('category_id', $value);
        });

        $query->when($options['status'], function (Builder $query, $value) {
            $query->where('status', $value);
        });

        $query->when($options['tag_id'], function (Builder $query, $value) {

            $query->whereExists(function ($query) use ($value) {
                $query->select('product_tag.product_id')
                    ->from('product_tag')
                    ->whereRaw('product_tag.product_id = products.id')
                    ->where('product_tag.tag_id', $value);
            });

            // More Consume
//            $query->whereHas('tags', function ($query) use ($value) {
//                $query->where('id', $value);
//            });
        });

        return $query;
    }

    /************************** Observers ****************************/

    protected static function booted()
    {
        self::saved(function (Product $product) {
            Cache::forget('products_count');
            Cache::forget('products_active_count');
            Cache::forget('products_inactive_count');
            Cache::forget('products_draft_count');
            Cache::forget('products_featured_count');
            Cache::forget('products_archive_count');
        });

        self::deleted(function (Product $product) {
            Cache::forget('products_count');
            Cache::forget('products_active_count');
            Cache::forget('products_inactive_count');
            Cache::forget('products_draft_count');
            Cache::forget('products_featured_count');
            Cache::forget('products_archive_count');
        });
    }

    /**************************** Relations *************************/

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest()->limit(3);
    }

    /**************** Static Methods ****************/

    public static function translatedAttributes(): array
    {
        $attributes = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $attributes[$key . '.name'] = __('dashboard/product/create.name', ['lang' => __('lang_key.with_' . $key)]);
            $attributes[$key . '.short_description'] = __('dashboard/product/create.short_description', ['lang' => __('lang_key.with_' . $key)]);
            $attributes[$key . '.description'] = __('dashboard/product/create.description', ['lang' => __('lang_key.with_' . $key)]);
        }
        return $attributes;
    }

    public static function attributesNames(): array
    {
        return [
            ...self::translatedAttributes(),
            'tag_id' => __('dashboard/product/create.tag'),
            'tag_id.*' => __('dashboard/product/create.tag'),
            'category_id' => __('dashboard/product/create.category'),
            'store_id' => __('dashboard/product/create.store'),
            'slug' => __('dashboard/product/create.slug'),
            'price' => __('dashboard/product/create.price'),
            'compare_price' => __('dashboard/product/create.compare_price'),
            'status' => __('dashboard/product/create.status'),
            'logo' => __('dashboard/product/create.logo'),
        ];
    }
}
