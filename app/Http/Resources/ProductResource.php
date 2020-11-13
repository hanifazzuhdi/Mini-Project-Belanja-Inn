<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'sold' => $this->sold,
            'weight' => $this->weight,
            'image' => $this->image,
            'created_at' => $this->created_at->format('d F Y'),
            'shop_id' => $this->shop_id,
            'category_id' => $this->category_id,
            'category' => $this->category->category_name,
            'shop' => $this->shop,
        ];
    }
}
