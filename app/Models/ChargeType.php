<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChargeType extends Model
{
    use HasFactory, SoftDeletes;

    const SLUG = [
        'airable_fee' => 'airable_fee',
        'surcharge' => 'surcharge',
        'custom_charges' => 'custom_charges',
        'bonded_charges' => 'bonded_charges'
    ];

}

