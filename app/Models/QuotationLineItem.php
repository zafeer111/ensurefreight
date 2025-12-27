<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationLineItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'carrier_id',
        'tariff_rate',
        'surcharge',
        'airable_charge',
        'custom_charge',
        'rate_per_kg',
        'zero_profit_rate',
        'total_rate',
        'status',
    ];

    public function quotable()
    {
        return $this->morphTo();
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }
}