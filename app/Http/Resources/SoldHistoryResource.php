<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SoldHistoryResource extends JsonResource
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
            'date' => $this->created_at,
            'user' => $this->order->user->only('id', 'name', 'username', 'avatar'),
            'product' => $this->product->only('id', 'product_name', 'price', 'image')
        ];
    }
}
