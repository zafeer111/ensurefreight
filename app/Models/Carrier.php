<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'carriers'; 

    protected $fillable = [
        'carrier_code',
        'carrier',
        'logo',
        'carrier_name',
        'type',
        'status',
    ];

    public function cargoRates()
    {
        return $this->hasMany(CargoRate::class, 'airline_id', 'id');
    }

    public function flights()
    {
        return $this->hasMany(Flight::class, 'carriers_id');
    }

    public function carrierTariffs()
    {
        return $this->hasMany(CarrierTariff::class);
    }

    public function getTypeAttribute()
    {
        $types = [1 => 'Airline', 2 => 'Truck', 3 => 'Ship', 4 => 'Train'];

        return $types[$this->attributes['type']] ?? null;
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 1 ? 'Active' : 'Inactive';
    }

    protected function logo() : Attribute
    {
        return Attribute::make(
            get: fn (string|null $value) => $this->getLogoUrl($value),
        );
    }

    private function getLogoUrl($value)
    {

       return $value ? asset('/storage' . '/' . $value) : asset(constants('carrier.logo.path'));

    }
}

