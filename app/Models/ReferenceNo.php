<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferenceNo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['reference_no'];

    public function inquiry()
    {
        return $this->hasOne(Inquiry::class);
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
