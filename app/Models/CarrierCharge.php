<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarrierCharge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'carrier_id',
        'currency_id',
        'charges_amt',
        'charge_type_id',
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function chargeType()
    {
        return $this->belongsTo(ChargeType::class);
    }

    public function carrierTariff()
    {
        return $this->belongsTo(CarrierTariff::class, 'carrier_id');
    }
}
