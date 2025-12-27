<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measurement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'weight',
        'width',
        'height',
        'length',
        'quantity',
        'dimension_unit',
        'weight_unit',
        'measurementable_id',
        'measurementable_type',
    ];

    public function measurementable()
    {
        return $this->morphTo();
    }
}
