<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['title','key', 'value','created_at'];

    // Cast for the 'value' attribute
    protected $casts = [
        'value' => 'json',
    ];
}
