<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoRate extends Model
{
    use HasFactory;

    protected $fillable = ['origin_code', 'destination_code', 'min_weight', 'max_weight', 'rate', 'airline_id'];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'airline_id', 'id');
    }

}
