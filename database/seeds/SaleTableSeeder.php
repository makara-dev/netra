<?php

use App\Sale;
use Illuminate\Database\Seeder;
class SaleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sales = [
            // sale1
            [
                'datetime' => '2021/04/20 14:46',
                'reference_num' => '001',
                'sale_status' => 'Pending',
                'payment_status' => 'Due',
                'total' => 10.50,
                'paid' => 10.50,
                'sale_note' => 'sale note',
                'staff_note' => 'staff note',
                'customer_id' => 1,
            ],

            // sale2
            [
                'datetime' => '2021/04/20 14:47',
                'reference_num' => '002',
                'sale_status' => 'Pending',
                'payment_status' => 'Due',
                'total' => 100.50,
                'paid' => 50.50,
                'sale_note' => 'sale note',
                'staff_note' => 'staff note',
                'customer_id' => 1,
            ],

            // sale3
            [
                'datetime' => '	2021/04/20 14:48',
                'reference_num' => '003',
                'sale_status' => 'Pending',
                'payment_status' => 'Due',
                'total' => 1000.50,
                'paid' => 100.50,
                'sale_note' => 'sale note',
                'staff_note' => 'staff note',
                'customer_id' => 1,
            ],
        ];
        
        // save data of sales 

        foreach($sales as $sale){
            Sale::create($sale);
        }
    }
}
