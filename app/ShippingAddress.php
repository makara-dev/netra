<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    //
    protected $primaryKey = 'shipping_address_id';

    protected $fillable = [
        'address', 'apartment_unit', 'note', 'sangkat_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function sangkat(){
        return $this->belongsTo(Sangkat::class, 'sangkat_id', 'sangkat_id');
    }

    public function shippingDetails(){
        return $this->hasMany(ShippingDetail::class, 'shipping_address_id', 'shipping_address_id');
    }
}
