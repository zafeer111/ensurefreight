<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarrierTariff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'carrier_tariffs';

    protected $fillable = [
        'carrier_id',
        'cargo_type',
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }

    public function tariffValidations()
    {
        return $this->hasMany(CarrierTariffValidation::class, 'carrier_tariff_id');
    }

    public function tariffDetails()
    {
        return $this->hasMany(TariffDetail::class);
    }
}
