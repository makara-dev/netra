<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    //
    protected $primaryKey = 'attribute_id';

    //
    protected $fillable = [
        'attribute_name'  
    ];

    //one to many relationship
    public function attributeValues(){
        return $this->hasMany(AttributeValue::class,'attribute_id','attribute_id');
    }

    //many to many
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'categories_attributes_bridge',
            'attribute_id',
            'category_id'
        );
    }
}
