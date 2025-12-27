<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nnjeim\World\Models\State as WorldState;

class State extends WorldState
{
    use HasFactory;

    protected $fillable = ['name', 'country_id'];

    public function myCountry()
    {
        return $this->belongsTo(Country::class, 'country_code', 'iso2');
    }

    public function myCities()
    {
        return $this->hasMany(City::class, 'state_code', 'state_code');
    }
}
