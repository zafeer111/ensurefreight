<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AirlineTariff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'carriers_id',
        'type',
        'valid_at',
        'expire_at',
        'cad_usd_conversion_rate',
        'extra_charges',
        'extra_charges_currency',
        'custom_charges',
        'customer_charges_currency',
        'max_height',
        'max_width',
        'max_length',
    ];

    public function tariffDetails()
    {
        return $this->hasMany(TariffDetail::class, 'airline_tariff_id');
    }
}
