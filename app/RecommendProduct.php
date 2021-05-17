<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecommendProduct extends Model
{
    //
    protected $table = "recommend_products";
    
    //
    protected $primaryKey = "recommend_product_id";

    //
    protected $fillable = [
        'product_variant_id',
        'thumbnail',
    ];

    // one to one relationship
    public function productVariant(){
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'product_variant_id');
    }
}
