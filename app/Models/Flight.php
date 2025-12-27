<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'flights';

    protected $fillable = [
        'carriers_id',
        'departure_airport_code',
        'arrival_airport_code',
    ];

    public function schedules()
    {
        return $this->hasMany(FlightSchedule::class, 'flight_id');
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carriers_id');
    }
}