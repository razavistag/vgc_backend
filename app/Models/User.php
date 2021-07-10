<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
        'phone',
        'address',
        'attempts',
        'google_id',
        'facebook_id',
        'twitter_id',
        'nic',
        'gender',
        'profilePic',
        'access',
        'status',
        'role',
        'dob',
        'language',
        'city',
        'location',
        'zip',
        'account_number',
        'user_type', // CUSTOMER  OR VENDOR OR SUPPLIER
        'opening_balance',
        'balance',
        'credit_limit',
        'payment_terms',  // ?
        'sales_rep_id', // ?
        'basic_salary',
        'monthly_target',
        'target_percentage',
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
    public function City()
    {
        return $this->hasMany(Location::class, 'id', 'city');
    }
    public function AdditionalInformation()
    {
        return $this->hasMany(UserInformation::class, 'user_id', 'id');
    }

    public function Location()
    {
        return $this->hasMany(Location::class, 'id', 'location');
    }
}
