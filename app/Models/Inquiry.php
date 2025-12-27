<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inquiries';


    protected $fillable = [
        'shipment_address_id',
        'pickup_address_id',
        'mode',
        'dest_iata',
        'destination_postal_code',
        'commodity',
        'incoterms',
        'cargo_type',
        'pickup_date',
        'broker_detail_id',
        'priority',
        'pickup_reference',
        'user_reference_number',
        'reference_no_id',
        'notes',
        'customer_user_id',
        'status',
        'user_agent',
        'ip',
    ];

    public function getStatusAttribute()
    {
    $statuses = Config::get('constants.status');
    $statusValue = $this->attributes['status'];

    return $statuses[$statusValue] ?? $statusValue;
    }
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('j M Y g:i A');
    }

    public function pickupAddress()
    {
        return $this->belongsTo(Addresses::class, 'pickup_address_id');
    }

    public function shipmentAddress()
    {
        return $this->belongsTo(Addresses::class, 'shipment_address_id');
    }

    public function brokerDetail()
    {
        return $this->belongsTo(BrokerDetail::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function customerUser()
    {
        return $this->belongsTo(CustomerUser::class, 'customer_user_id', 'id');
    }
    
    public function customer()
    {
    return $this->belongsTo(Customer::class);
    }
    
    public function measurements()
    {
        return $this->morphMany(Measurement::class, 'measurementable');
    }

    public function exceptionInquiry()
    {
        return $this->morphOne(ExceptionInquiry::class, 'exceptionable');
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }

    public function referenceNo()
    {
        return $this->belongsTo(ReferenceNo::class, 'reference_no_id');
    }

    public function conditionsForPickup()
    {
        return $this->hasOne(ConditionForPickup::class);
    }
}
