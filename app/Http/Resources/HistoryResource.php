<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'date' => $this->created_at->translatedFormat('l, d F Y H:i'),
            'product' => $this->product->only('product_name', 'price', 'image'),
            'shop' => $this->shop->only('shop_name', 'avatar')
        ];
    }
}
