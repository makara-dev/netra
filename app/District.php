<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    protected $primaryKey = 'district_id';

    protected $fillable = [
        'district_name'
    ];

    public function sangkats(){
        return $this->hasMany(Sangkat::class, 'district_id', 'district_id');
    }
}
