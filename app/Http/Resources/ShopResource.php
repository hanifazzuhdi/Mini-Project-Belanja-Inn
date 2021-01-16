<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            'user_id' => $this->user_id,
            'shop_name' => $this->shop_name,
            'avatar' => $this->avatar,
            'address' => $this->address,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'products' => $this->product
        ];
    }
}
