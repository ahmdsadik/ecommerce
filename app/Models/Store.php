<?php

namespace App\Models;

use App\Enums\StoreStatus;
use App\Traits\UploadMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Store extends Model implements TranslatableContract, HasMedia
{
    use SoftDeletes, HasFactory, Translatable, InteractsWithMedia, UploadMedia;

    protected $fillable = [
        'slug',
        'user_id',
        'status',
    ];

    public array $translatedAttributes = ['name', 'description', 'short_description'];

    protected $with = ['translations'];

    protected $casts = [
        'status' => StoreStatus::class,
    ];

    public function getReadableStatusAttribute(): string
    {
        return match ($this->status) {
            StoreStatus::ACTIVE => __('dashboard/status.active'),
            StoreStatus::INACTIVE => __('dashboard/status.inactive'),
            default => __('dashboard/status.un_known')
        };
    }

    /****************** Media ***********************/

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->useFallbackUrl(asset('assets/dashboard/default/store/store.jpg'))
            ->useDisk('stores')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg', 'image/jpg'])
//            ->registerMediaConversions(function (Media $media){
//
//            })
        ;

        $this->addMediaCollection('cover')
            ->useFallbackUrl(asset('assets/dashboard/images/dashboard/1.png'))
            ->useDisk('stores')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg', 'image/jpg'])
//            ->registerMediaConversions(function (Media $media){
//
//            })
        ;
    }

    /****************** Scopes ************************/

    public function scopeMainCategory($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(StoreStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(StoreStatus::INACTIVE);
    }

    /******************** Relations *********************/

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
