<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promoset extends Model
{
    //
    protected $table = "promosets";

    // 
    protected $primaryKey = "promoset_id";

    // 
    protected $fillable = [
        "promoset_name"         ,
        "promoset_condition"    ,
        "provider_condition"    ,
        "discount_price_offer"  ,
        "promoset_thumbnail"    ,
        "promoset_description"  ,
    ];

    // many to many
    public function productVariantsPurchase(){
        return $this->belongsToMany(
            ProductVariant::class, 
            'pvpurchase_promoset_bridges',
            'promoset_id',
            'product_variant_id'
        );
    }

    // many to many
    public function productVariantsFree(){
        return $this->belongsToMany(
            ProductVariant::class, 
            'pvfree_promoset_bridges',
            'promoset_id',
            'product_variant_id'
        );
    }
}
