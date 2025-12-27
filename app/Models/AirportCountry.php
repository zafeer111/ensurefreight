<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AirportCountry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'airport_countries';

    protected $fillable = [
        'country_id',
        'airport_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function airport()
    {
        return $this->belongsTo(Airport::class);
    }
}
