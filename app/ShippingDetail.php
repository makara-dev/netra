<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    //
    protected $primaryKey = 'shipping_detail_id';

    protected $fillable = [
        'name', 'contact', 'email', 'address', 'apartment_unit', 'note', 'sangkat_name', 'district_name', 'receiver_numbers'
    ];

    public function shippingAddress(){
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id', 'shipping_address_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
