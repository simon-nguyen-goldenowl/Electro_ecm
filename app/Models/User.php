<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use williamcruzme\FCM\Traits\HasDevices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    use HasDevices;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'address',
        'phone',
        'email',
        'username',
        'password',
        'is_admin',
        'reset_key',
        'reset_key_time',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function scopeName($query, $request)
    {
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('name', 'like', '%' . $name . '%');
        }
        return $query;
    }
    public function scopeCode($query, $request)
    {
        if ($request->has('code')) {
            $code = $request->input('code');
            $query->where('code', 'like', '%' . $code . '%');
        }
        return $query;
    }
    public function scopeAddress($query, $request)
    {
        if ($request->has('address')) {
            $address = $request->input('address');
            $query->where('address', 'like', '%' . $address . '%');
        }
        return $query;
    }

    public function scopePhone($query, $request)
    {
        if ($request->has('phone')) {
            $phone = $request->input('phone');
            $query->where('phone', 'like', '%' . $phone . '%');
        }
        return $query;
    }

    public function scopeEmail($query, $request)
    {
        if ($request->has('email')) {
            $email = $request->input('email');
            $query->where('email', 'like', '%' . $email . '%');
        }
        return $query;
    }
}
