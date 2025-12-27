<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AirportCity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'airport_cities';

    protected $fillable = [
        'city_id',
        'airport_id',
        ];


}
