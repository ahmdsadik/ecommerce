<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Laratrust\Models\Permission as PermissionModel;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Permission extends PermissionModel implements TranslatableContract
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
        $attributes = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {

            foreach ((new self())->translatedAttributes as $attr) {
                $attributes[$key . ".$attr"] = __('dashboard/permission/create.' . $attr, ['lang' => __('lang_key.with_' . $key)]);
            }

        }
        return $attributes;
    }

    public static function attributesNames(): array
    {
        return [
            self::translatedAttributes()
        ];
    }
}
