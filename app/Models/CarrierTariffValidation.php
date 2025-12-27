<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarrierTariffValidation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'carrier_tariff_id',
        'valid_at',
        'expire_at',
        'max_height',
        'max_width',
        'max_length',
    ];

    public function carrierTariff()
    {
        return $this->belongsTo(CarrierTariff::class);
    }
}
