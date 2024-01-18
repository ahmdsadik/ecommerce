<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

trait UploadMedia
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function uploadImage(string $imageInput, string $collectionName): void
    {
        $this->addMediaFromRequest($imageInput)
            ->toMediaCollection($collectionName);
        //                    ->withResponsiveImages()
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function uploadImages(string $imageInput, string $collectionName): void
    {
        foreach (request()->file($imageInput) as $image) {
            $this->addMedia($image)
                ->toMediaCollection($collectionName);
        }
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function clearAndUpdateCollection(string $imageInput, string $collectionName): void
    {
        if ($this->hasMedia($collectionName)) {
            $this->clearMediaCollection($collectionName);
        }
        $this->uploadImages($imageInput, $collectionName);
    }

}
