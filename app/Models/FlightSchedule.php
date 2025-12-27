<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlightSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'flight_schedules';
    
    protected $fillable = [
        'flight_id',
        'day',
        'departure_time',
        'arrival_time',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }
}