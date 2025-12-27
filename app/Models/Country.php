<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nnjeim\World\Models\Country as WorldCountry;
class Country extends WorldCountry
{
    use HasFactory;

    protected $fillable = ['name'];

    public function myStates()
    {
        return $this->hasMany(State::class);
    }
}
