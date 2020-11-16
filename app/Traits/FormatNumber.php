<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatNumber
{
    protected $newDateFormat = 'l, d F Y H:i';

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

    // Mengganti format value dari kolom price saat akan di tampilkan
    public function getPriceAttribute()
    {
        return number_format($this->attributes['price'], 0, ',', '.');
    }

    // Mengganti format value dari kolom total_price saat akan di tampilkan
    public function getTotalPriceAttribute()
    {
        return number_format($this->attributes['total_price'], 0, ',', '.');
    }
}
