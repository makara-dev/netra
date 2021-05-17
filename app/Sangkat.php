<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sangkat extends Model
{
    //
    protected $primaryKey = 'sangkat_id';

    protected $fillable = [
        'sangkat_name', 'delivery_fee'
    ];

    public function district(){
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    public function shippingAddresses(){
        return $this->hasMany(ShippingAddress::class, 'sangkat_id', 'sangkat_id');
    }
}
