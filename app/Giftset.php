<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giftset extends Model
{
    //
    protected $primaryKey = 'giftset_id';

    //
    protected $fillable = [
        'giftset_name',
        'expires_at',
        'giftset_cost',
        'giftset_price',
        'thumbnail',
        'giftset_description',
    ];

    // many to many relationship
    public function attributeValues(){
        return $this->belongsToMany(
            AttributeValue::class,
            'giftset_attrval_bridges',
            'giftset_id',
            'attribute_value_id' 
        );
    }

    // many to one relationship
    public function invoice(){
        return $this->belongsTo(Invoice::class,'giftset_id','giftset_id');
    }

    // many to many (new update)
    public function productVariants() {
        return $this->belongsToMany(
            ProductVariant::class, 
            'productvar_giftset_bridges',
            'giftset_id',
            'product_variant_id'
        );
    }
}
