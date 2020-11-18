<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'product_id' => $this->product_id,
            'order_id'  => $this->order_id,
            'quantity'  => $this->quantity,
            'product'   => $this->product->only('id', 'product_name', 'image'),
            'shop'  => $this->product->shop->only('id', 'shop_name', 'avatar')
        ];
    }
}
