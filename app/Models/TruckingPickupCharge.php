<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TruckingPickupCharge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'min_weight',
        'max_weight',
        'min_rate',
        'max_rate',
        'rate_currency',
        'max_skids',
    ];
}
