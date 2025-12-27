<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotes_id',
        'status',
        'new_rate'
    ];

    public function negotiable()
    {
        return $this->morphTo();
    }
}
