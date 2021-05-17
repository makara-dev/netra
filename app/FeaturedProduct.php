<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedProduct extends Model
{   
    //
    protected $table = 'featured_products';

    //
    protected $primaryKey = 'featured_product_id';

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
