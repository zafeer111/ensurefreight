<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Notifications\Notifiable;

class CustomerUser extends AuthenticatableUser implements Authenticatable, CanResetPassword
{
    use HasFactory, SoftDeletes, HasUuids, AuthenticatableTrait, CanResetPasswordTrait, Notifiable;

    protected $table = 'customer_users';
    protected $primaryKey = 'customer_user_uuid';

    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'password',
        'customer_user_uuid',
        'phone',
        'country_id',
        'city_id',
        'state_id',
        'postal_code',
        'is_active',
        'gender',
        'created_by',
        'updated_by',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function getUserImgAttribute($value)
    {
        // If no user image is provided, set a custom default image path
        return $value ?: 'src/images/default-avatar.jpg';
    }

    public function addresses($sortBy = 'DESC')
    {
        return $this->hasMany(Addresses::class, 'customer_user_id', 'id')->orderBy('created_at',$sortBy)
        ->orderBy('updated_at',$sortBy);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function airport()
    {
        return $this->belongsTo(Airport::class);
    }
    public function getIsActiveAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Inactive';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
