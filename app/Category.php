<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class Category extends Model
{

    //
    protected $table = 'categories';

    //
    protected $primaryKey = 'category_id';

    //
    protected $fillable = [
        'category_name', 'attribute_id'
    ];

    public $timestamps = true;

    //one to many 
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }

    //many to many
    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'categories_attributes_bridge',
            'category_id',
            'attribute_id'
        );
    }

    /**
     * get attributes
     * 
     */
    public function selectAllAttributes()
    {
        //get products
        $products = $this->products;
        $attributes = new EloquentCollection();
        foreach ($products as $product) {
            $tempAttributes = $product->selectAllAttributes();
            foreach($tempAttributes as $tempAttribute){
                if ($attributes->where('attribute_id', $tempAttribute->attribute_id)->count() == 0) { //add non-duplicates into attributes collection
                    $attributes->add($tempAttribute);  //add to the collection
                }
            }
        }
        return $attributes;
    }

}
