<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    //primary key for table
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'contact', 
        'provider', 
        'password', 
        'provider_id',
    ];

    public $timestamps = true;

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

    //one to one relationship
    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id', 'user_id');
    }

    //one to one relationship
    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id', 'user_id');
    }

    // one to many
    public function reviews() {
        return $this->hasMany(Review::class, 'customer_id', 'customer_id');
    }

    /**
     * Get customer model with all user field
     * @return App\Customer
     */
    public function getCustomerWithUserFields()
    {
        $user = $this;

        $customer = $user->customer;

        $customer->name    = $user->name;
        $customer->email   = $user->email;
        $customer->contact = $user->contact;
        $customer->address = $user->address;

        return $customer;
    }
}
