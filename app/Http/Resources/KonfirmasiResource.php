<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KonfirmasiResource extends JsonResource
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
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'product' => $this->product->only('id', 'product_name', 'price', 'weight'),
            'shop' => $this->shop->only('id', 'shop_name', 'avatar')
        ];
    }
}
