<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Tag */
class TagResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->readable_status,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'readable_status' => $this->readable_status,
//            'products_count' => $this->products_count,

//            'products' => ProductCollection::collection($this->whenLoaded('products')),
        ];
    }
}
