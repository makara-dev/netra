<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    //
    protected $primaryKey = 'image_id';

    //
    protected $fillable = ['path', 'is_thumbnail'];

    //many to one relationship
    public function product(){
        return $this->belongsTo(Product::class,'product_id','product_id');
    }
}

