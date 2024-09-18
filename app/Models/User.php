<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'refer_code',
        'password',
        'balance',
        'profile_pic',
        'referred_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getProfilePicAttribute($value)
    {
        if (!$value == null) {
            return asset(Storage::url($value));
        }
        return asset('AdminAssets/assets/img/user.png.png');
    }
    public function GetReferredBy()
    {
        return $this->hasOne(User::class, 'refer_code', 'referred_by');
    }
    public function UserBlocked()
    {
        return $this->hasOne(BlockedUser::class, 'user_id', 'id');
    }
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by', 'refer_code');
    }
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by', 'refer_code');
    }
}
