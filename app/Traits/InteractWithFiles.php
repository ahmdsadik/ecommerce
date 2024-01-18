<?php

namespace App\Traits;

trait InteractWithFiles
{

    public function uploadImage(object $model, string $imageInput, string $collectionName): void
    {
        $model->addMediaFromRequest($imageInput)
            ->toMediaCollection($collectionName);
        //                    ->withResponsiveImages()
    }

    public function uploadImages(object $model, string $imageInput, string $collectionName): void
    {
        foreach (request()->file($imageInput) as $image) {
            $model->addMedia($image)
                ->toMediaCollection($collectionName);
        }
    }

    public function clearAndUpdateCollection(object $model, string $imageInput, string $collectionName): void
    {
        if ($model->hasMedia($collectionName)) {
            $model->clearMediaCollection($collectionName);
        }
        $this->uploadImages($model, $imageInput, $collectionName);
    }

}
