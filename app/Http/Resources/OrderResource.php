<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => Carbon::parse($this->date)->translatedFormat('l, d F Y H:i'),
            'status' => $this->status,
            'total_price' => number_format($this->total_price, 0, ',', '.'),
            'created_at' => $this->created_at->translatedFormat('l, d F Y H:i'),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
