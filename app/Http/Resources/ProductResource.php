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
            'product_name' => $this->product_name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'image' => $this->image,
            'shop_id' => $this->shop_id,
            'category' => $this->category->category_name,
            'sub_image1' => $this->sub_image1,
            'sub_image2' => $this->sub_image2,
            'created_at' => $this->created_at->format('d F Y')
        ];
    }
}
