<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleReport extends Model
{

    //
    protected $primaryKey = 'sale_report_id';

    //one to many relationship
    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'sale_report_id', 'sale_report_id');
    }
}
