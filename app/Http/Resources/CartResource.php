<?php

namespace App\Http\Resources;

use App\Traits\FormatNumber;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    use FormatNumber;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "order_id" => $this->order_id,
            "quantity" => $this->quantity,
            "total_price" => $this->formatPrice($this->total_price),
            "created_at" => $this->created_at,
            "product" => $this->product->only('id', 'product_name', 'price', 'image', 'weight'),
            "shop" => $this->product->shop->only('id', 'shop_name'),
        ];
    }

}
