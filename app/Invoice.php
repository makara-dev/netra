<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $primaryKey = 'invoice_id';

    //
    protected $fillable = [
        'total_cost',
        'total_price',
        'grand_total',
        'delivery_fee',
        'sale_tax',
        'grand_total',
    ];

    public $timestamps = true;

    //many to one relationship
    public function saleReport()
    {
        return $this->belongsTo(SaleReport::class, 'sale_report_id', 'sale_report_id');
    }

    //one to one relationship()
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
