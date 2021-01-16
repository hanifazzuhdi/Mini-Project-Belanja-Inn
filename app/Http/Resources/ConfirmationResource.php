<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfirmationResource extends JsonResource
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
            'status' => $this->status,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'date' => $this->created_at,
            'product' => $this->product->only('id', 'product_name', 'price'),
            'shop' => $this->shop->only('id', 'shop_name', 'avatar')
        ];
    }
}
