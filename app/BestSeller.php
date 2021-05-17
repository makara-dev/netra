<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestSeller extends Model
{
    //
    protected $table = "best_sellers";
    
    //
    protected $primaryKey = "best_seller_id";

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
