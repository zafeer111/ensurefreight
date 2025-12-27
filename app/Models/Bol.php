<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bol extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'attachment_url',
        'storage_type',
        'booking_id',
        'additional_information',
        'updated_by',
        'status',
    ];

    protected $casts = [
        'additional_information' => 'json',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
