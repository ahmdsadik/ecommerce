<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    /**
     * @throws \Exception
     */
    public function getPath(Media $media): string
    {
        return md5($media->id  . getenv('APP_KEY')) . '/';
    }

    /**
     * @throws \Exception
     */
    public function getPathForConversions(Media $media): string
    {
        return md5($media->id  . getenv('APP_KEY')) . '/conversions/';
    }

    /**
     * @throws \Exception
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return md5($media->id  . getenv('APP_KEY')) . '/responsive-images/';
    }
}
