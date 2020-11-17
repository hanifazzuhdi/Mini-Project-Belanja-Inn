<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "product" => $this->product->only('id', 'product_name', 'price', 'image', 'weight'),  
            "shop" => $this->product->shop->only('id', 'shop_name'),  
            "category" => $this->product->category->only('id', 'category_name'),  
            "order_id" => $this->order_id,
            "quantity" => $this->quantity,
            "total_price" => $this->total_price,
            "created_at" => $this->created_at->translatedFormat('l, d F Y H:i'),
            "updated_at" => $this->updated_at->diffForhumans()
        ];
    }
}
