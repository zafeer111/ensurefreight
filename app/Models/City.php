<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nnjeim\World\Models\City as WorldCity;

class City extends WorldCity
{
    use HasFactory;

    protected $fillable = ['name', 'state_id'];

    public function myState()
    {
        return $this->belongsTo(State::class, 'state_code', 'state_code');
    }

    public function airport()
    {
        return $this->belongsToMany(Airport::class, 'airport_cities');
    }


}
