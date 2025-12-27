<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'unit_per_usd',
        'usd_per_unit',
        'name',
        'code',
        'precision',
        'symbol',
        'symbol_native',
        'symbol_first',
        'decimal_mark',
        'thousands_separator',
    ];

    protected $with = ['country'];

    const CODE = [
        'USD' => 'USD',
        'CAD' => 'CAD'
    ];
    protected $appends = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
