<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use App\Traits\UploadMedia;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements TranslatableContract, HasMedia
{
    use HasFactory, Translatable, InteractsWithMedia, UploadMedia;

    protected $fillable = [
        'parent_id',
        'slug',
        'status',
    ];

    public array $translatedAttributes = ['name', 'description'];

    protected $with = ['translations'];

    protected $casts = [
        'status' => CategoryStatus::class
    ];

    public function getReadableStatusAttribute(): string
    {
        return match ($this->status) {
            CategoryStatus::ACTIVE => __('dashboard/status.active'),
            CategoryStatus::INACTIVE => __('dashboard/status.inactive'),
            default => __('dashboard/status.un_known')
        };
    }


    /****************** Media **************************/
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->useFallbackUrl(asset('assets/dashboard/default/category/categories.png'))
            ->useDisk('categories')
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
        return $query->whereStatus(CategoryStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(CategoryStatus::INACTIVE);
    }


    /********************* Scope Cache **************************/

    public function scopeParentAndActiveCached($query)
    {
        return Cache::rememberForever('Front-Cat', fn() => self::mainCategory()->active()->select('id')
            ->withCount('children')->with('children:id,parent_id')->get()
        );
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('Front-Cat');
        });

        static::deleted(function () {
            Cache::forget('Front-Cat');
        });
    }

    /******************* Relations *******************/

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
}
