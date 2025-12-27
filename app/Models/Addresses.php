<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addresses extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_user_id',
        'country_id',
        'state_id',
        'city_id',
        'postal_code',
        'address',
        'contact_name',
        'contact_email',
        'phone_number',
    ];
    protected $with = ['country','state','city'];
    public function inquiriesAsSupplier()
    {
        return $this->hasMany(Inquiry::class, 'supplier_address_id');
    }

    public function inquiriesAsDelivery()
    {
        return $this->hasMany(Inquiry::class, 'delivery_address_id');
    }

    public function inquiriesAsShipment()
    {
        return $this->hasMany(Inquiry::class, 'shipment_address_id');
    }

    public function customerUser()
    {
        return $this->belongsToMany(CustomerUser::class, 'customer_user_id');
    }

    // public function formattedAddress()
    // {
    //     return "{$this->address}, City: { $this->city }, 
    //     Postal Code: {{ $this->postal_code }}";
    // }

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
}
