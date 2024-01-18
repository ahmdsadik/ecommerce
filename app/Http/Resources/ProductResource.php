<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'store_id' => $this->store_id,
            'slug' => $this->slug,
            'price' => $this->price,
            'compare_price' => $this->compare_price,
            'qty' => $this->qty,
            'options' => $this->options,
            'rating' => $this->rating,
            'feature' => $this->feature,
            'viewed' => $this->viewed,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'readable_status' => $this->readable_status,
            'category' => $this->category->name,
            'store' => $this->store->name,
            'image_url' => $this->getFirstMediaUrl('logo')
        ];
    }
}
