<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    //
    protected $table = 'attribute_values';

    //
    protected $primaryKey = 'attribute_value_id';

    //
    protected $fillable = [
        'attribute_value'
    ];

    //many to one
    public function attribute(){
        return $this->belongsTo(Attribute::class,'attribute_id','attribute_id');
    }

    //many to many
    public function giftsets(){
        return $this->belongsToMany(
            Giftset::class,
            'giftset_attrval_bridges',
            'attribute_value_id',
            'giftset_id'
        );
    }

    //many to many 
    public function productVariants(){
        return $this->belongsToMany(
            ProductVariant::class,
            'productvariant_attributevalue_bridge',
            'attribute_value_id',
            'product_variant_id'
        );
    }

}
