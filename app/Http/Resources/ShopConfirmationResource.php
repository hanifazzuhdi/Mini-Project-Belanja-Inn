<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopConfirmationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'date' => $this->created_at,
            'product' => $this->product->only('id', 'product_name', 'price'),
            'user' => $this->order->user->only('id', 'username', 'avatar')
        ];
    }
}
