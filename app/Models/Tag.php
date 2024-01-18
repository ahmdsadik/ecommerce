<?php

namespace App\Models;

use App\Enums\TagStatus;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Tag extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public array $translatedAttributes = ['name'];

    protected $fillable = [
        'slug',
        'status',
    ];

    protected $with = ['translations'];

    protected $casts = [
        'status' => TagStatus::class
    ];

    public function getReadableStatusAttribute(): string
    {
        return
            match ($this->status) {
                TagStatus::ACTIVE => __('dashboard/status.active'),
                TagStatus::INACTIVE => __('dashboard/status.inactive'),
                default => __('dashboard/status.un_known')
            };
    }

    /********************** Scopes ************************/

    public function scopeCachedCount()
    {
        return Cache::rememberForever('tags-count', fn() => self::count());
    }

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::saved(function () {
//            Cache::forget('tags-count');
//        });
//
//        static::deleted(function () {
//            Cache::forget('tags-count');
//        });
//    }


    public function scopeActive($query)
    {
        return $query->whereStatus(TagStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(TagStatus::INACTIVE);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $options = array_merge([
            'status' => null
        ], $filters);

        $query->when($options['status'], function (Builder $query, $value) {
            $query->where('status', $value);
        });


        return $query;
    }

    /********************* Relations *********************/
//
//    /**
//     * Get all the brands that are assigned with this tag.
//     */
//    public function brands(): MorphToMany
//    {
//        return $this->morphedByMany(Brand::class, 'taggable');
//    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /***************** Static *******************/

    public static function translatedAttributes(): array
    {
        $attributes = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $attributes[$key . '.name'] = __('dashboard/tag/create.name', ['lang' => __('lang_key.with_' . $key)]);
        }
        return $attributes;
    }

    public static function attributesNames(): array
    {
        return [
            self::translatedAttributes(),
            'status' => __('dashboard/tag/edit.status'),
            'slug' => __('dashboard/tag/edit.slug')
        ];
    }
}
