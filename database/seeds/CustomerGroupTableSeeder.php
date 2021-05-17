<?php

use App\CustomerGroup;
use App\Customer;
use Illuminate\Database\Seeder;

class CustomerGroupTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $customersGroups = [
            // Customer group 1
            [
                'name'      => 'Walk in customer',
                'discount'  => 0.00,
            ],

            // Customer group 2
            [
                'name'      => 'B Banker',
                'discount'  => 30,
            ],

            // Customer group 3
            [
                'name'      => 'C Banker',
                'discount'  => 20.5,
            ],

            // Customer group 4
            [
                'name'      => 'D Banker',
                'discount'  => 50,  
            ],
        ];

        // save data into db
        foreach($customersGroups as $customersGroup){
            $CustomerGroup = CustomerGroup::create($customersGroup);
        }

    }
}
