<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'customer_uuid';
    
    protected $fillable = [
        'id',
        'type',
        'name',
        'address',
        'city_id',
        'country_id',
        'iata_code',
        'state_id',
        'postal_code',
        'phone',
        'alternate_phone_no',
        'fax',
        'cell_no',
        'email',
        'airport_id',
        'account_no',
        'contact_person',
        'domain',
        'customer_uuid',
        'created_by',
        'updated_by',
        
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function airport()
    {
        return $this->belongsTo(Airport::class, 'airport_id');
    }
}
