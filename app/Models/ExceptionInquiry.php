<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExceptionInquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'inquiry_id',
        'exception_message',
        'status'
    ];

    public function exceptionable()
    {
        return $this->morphTo();
    }
}
