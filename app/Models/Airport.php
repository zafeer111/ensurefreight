<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'airports';

    protected $fillable = [

        'name',
        'iata_code',
        'country_id',
        'city_id',
        'postal_code',
        'state_id',
        'updated_at',
        'created_at'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function airportCity()
    {
        return $this->belongsToMany(City::class, 'airport_cities');
    }
}
