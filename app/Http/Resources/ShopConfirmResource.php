<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopConfirmResource extends JsonResource
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
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'buyer' => $this->order->user->only('id', 'username', 'avatar', 'address', 'phone_number'),
            'product' => $this->product->only('id', 'product_name', 'image')
        ];
    }
}
