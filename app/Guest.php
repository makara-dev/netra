<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    //
    protected $primaryKey = 'guest_id';

    //
    protected $fillable = [
        'name', 'address', 'contact'
    ];

    //one to many polymorphic relation
    public function invoice(){
        return $this->morphMany(Invoice::class, 'invoiceable', 'invoiceable_type', 'invoiceable_id', 'guest_id');
    }

}
