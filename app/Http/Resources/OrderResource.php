<?php

namespace App\Http\Resources;

use App\Traits\FormatNumber;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    use FormatNumber;

    public function toArray($request)
    {   
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'status' => $this->status,
            'total_price' => $this->formatPrice($this->total_price),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
