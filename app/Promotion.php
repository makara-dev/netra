<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    //
    protected $primaryKey = 'promotion_id';

    //
    protected $fillable = ['promo_code', 'discount_percentage', 'discount_percentage'];

    //one to one relationship
    public function order()
    {
        return $this->hasMany(Order::class, 'promotion_id', 'promotion_id');
    }
}
