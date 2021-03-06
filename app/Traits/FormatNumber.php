<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatNumber
{
    protected $newDateFormat = 'l, d F Y';

    // Mengganti format value dari kolom created_at saat akan di tampilkan
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat($this->newDateFormat);
    }

    // Mengganti format value dari kolom updated_at saat akan di tampilkan
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    public function formatPrice($price)
    {
        return number_format($price, 0, ',', '.');
    }
}
