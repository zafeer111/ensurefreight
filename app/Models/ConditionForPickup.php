<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionForPickup extends Model
{
    use HasFactory;

    protected $table = 'conditionsforpickup';

    protected $fillable = [
        'inquiry_id',
        'inside_pickup',
        'residential_pickup',
        'liftgate_required',
        'do_not_stack',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}
