<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_id',
        'customer_user_id',
        'reference_no_id',
        'carrier_id',
        'tariff_rate',
        'surcharge',
        'airable_charge',
        'custom_charge',
        'rate_per_kg',
        'total_rate',
        'status',
    ];

    public function customerUser()
    {
        return $this->belongsTo(CustomerUser::class, 'customer_user_id', 'id');
    }

    public function customer()
    {
    return $this->belongsTo(Customer::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function referenceNo()
    {
        return $this->belongsTo(ReferenceNo::class, 'reference_no_id');
    }
}
