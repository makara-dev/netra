<?php

use App\Order;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $orders = [
            // order1
            [
                'order_number' => '001',
                'total_cost' => 10,
                'total_price' => 20,
                'delivery_fee' => 10,
                'grand_total' => 10,
                'sale_tax' => 1,
                'sale_type' => 'Online',
                'payment_status' => 'Pending',
                'delivery_status' => 'Pending',
                'payment_method' => 'cash on delivery',
                'order_status' => 'Pending',
                'customer_id' => 1
            ],

            // order2
            [
                'order_number' => '002',
                'total_cost' => 10,
                'total_price' => 20,
                'delivery_fee' => 10,
                'grand_total' => 10,
                'sale_tax' => 1,
                'sale_type' => 'Online',
                'payment_status' => 'Pending',
                'delivery_status' => 'Pending',
                'payment_method' => 'cash on delivery',
                'order_status' => 'Pending',
                'customer_id' => 1
            ],

            // order3
            [
                'order_number' => '003',
                'total_cost' => 10,
                'total_price' => 20,
                'delivery_fee' => 10,
                'grand_total' => 10,
                'sale_tax' => 1,
                'sale_type' => 'Online',
                'payment_status' => 'Pending',
                'delivery_status' => 'Pending',
                'payment_method' => 'cash on delivery',
                'order_status' => 'Pending',
                'customer_id' => 1
            ],
        ];

        // save data of sales 

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
