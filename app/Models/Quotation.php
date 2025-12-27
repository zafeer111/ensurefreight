<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'inquiry_id',
        'customer_user_id',
        'reference_no_id',
        'from',
        'to',
        'weight',
        'pickup_carrier_name',
        'profit',
        'pickup_charge',
        'bonded_charge',
        'cargo_type',
        'status',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function quotationLineItems()
    {
        return $this->morphMany(QuotationLineItem::class, 'quotable');
    }

    public function referenceNo()
    {
        return $this->belongsTo(ReferenceNo::class, 'reference_no_id');
    }
}
