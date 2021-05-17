<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $primaryKey = 'order_detail_id';

    //
    protected $fillable = [
        'name', 'cost', 'price', 'quantity', 'thumbnail'
    ];

    //one to many relationship
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'product_variant_id');
    }

    //many to one relationship
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
    
}
