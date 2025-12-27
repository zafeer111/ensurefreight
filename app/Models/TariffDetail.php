<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrier_tariff_id',
        'origin_code',
        'destination_code',
        'min_weight',
        'max_weight',
        'rate',
    ];

    // Define relationships
    public function carrierTariff()
    {
        return $this->belongsTo(CarrierTariff::class);
    }
}
