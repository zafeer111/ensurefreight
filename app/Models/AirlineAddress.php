<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AirlineAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'carrier_id',
        'address',
        'sub_address',
        'city',
        'state',
        'postal_code',
        'port',
        'sub_location',
        'contact',
        'tel',
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }
}
