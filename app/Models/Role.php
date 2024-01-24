<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Laratrust\Models\Role as RoleModel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Role extends RoleModel implements TranslatableContract
{
    use Translatable;

    protected $fillable = [
      'name',
      'description',
    ];

    public array $translatedAttributes = ['display_name'];

//    protected $with = ['translations'];

    ########################## Static ############################

    public static function translatedAttributes(): array
    {
        return (new self())->translatedAttributes;
    }

    public static function translatedAttributesNames(): array
    {
        $attributes = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {

            foreach (self::translatedAttributes() as $attr) {
                $attributes[$key . ".$attr"] = __('dashboard/role/create.' . $attr, ['lang' => __('lang_key.with_' . $key)]);
            }

        }
        return $attributes;
    }

    public static function attributesNames(): array
    {
        return [
            self::translatedAttributesNames()
        ];
    }
}
