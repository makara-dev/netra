<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;

class Customer extends Model
{
    //
    protected $table = 'customers'; 

    //
    protected $primaryKey = 'customer_id';

    //
    protected $fillable = [
        'point'
    ];

    public $timestamps = true;
    
    // one to one relationship
    public function user(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }
    // one to one relationship
    public function order(){
        return $this->belongsTo(User::class,'order_id','order_id');
    }
    
    // one to many
    public function shippingAddresses(){
        return $this->hasMany(ShippingAddress::class, 'customer_id', 'customer_id');
    }

    /** 
     *   restore the customer shopping cart into session
     */
    public function shoppingCart(){
        Cart::restore($this->customer_id);
    }

     /**===============
     *  Relationships
     *=================*/
    
    /**
     * Many relationship with customer group
     */
    public function cusgroup()
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }
    /**===============
     *  Relationships
     *=================*/
    
    /**
     * one relationship with quotation 
     */

     public function quotations(){
         return $this->hasMany(Quoation::class, 'customer_id');
     } 
}
