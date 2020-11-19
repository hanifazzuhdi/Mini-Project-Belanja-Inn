<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CobaResource extends JsonResource
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
            // 'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'status' => $this->status,
            // 'total_price' => $this->total_price,
            // 'date' => $this->date,
            'order' => $this->cart
        ];
    }
}
