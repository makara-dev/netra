<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'reviews';

    //
    protected $primaryKey = 'review_id';

    // 
    protected $fillable = [
        'description',
        'user_id',
        'product_id',
        'rating',
    ];

    // many to one relationship
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // many to one relationship
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // date time format
    public function getReviewDate($date){
        $date = new Carbon($date->jsonSerialize());
        return $date->format('d / m / Y');
    }
}