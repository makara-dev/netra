<?php

use App\Giftset;
use Illuminate\Database\Seeder;

class GiftsetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $faker = Faker\Factory::create();

        // for($i = 0; $i <5 ; $i++ ){
        //     Giftset::create([
        //         'giftset_name' => $faker->unique()->word,
        //         'giftset_cost' => $faker->randomFloat(2, 0, 10.00),
        //         'giftset_price' => $faker->randomFloat(2, 15.00, 30.00),
        //         'expires_at' => $faker->creditCardExpirationDate,
        //     ]);
        // }
        
        // $data = [
        //     [
        //         'giftset_name'  => 'Gift Set 1',
        //         'giftset_cost'  => 20,
        //         'giftset_price' => 21.5,
        //         'giftset_description' => 'Special Set number 1',
        //         'expires_at'    => '2020-12-20 12:00:00',
        //     ],

        //     [
        //         'giftset_name'  => 'Gift Set 2',
        //         'giftset_cost'  => 15,
        //         'giftset_price' => 18,
        //         'giftset_description' => 'Special Set number 2',
        //         'expires_at'    => '2020-12-21 12:00:00',
        //     ],
            
        //     [
        //         'giftset_name'  => 'Gift Set 3',
        //         'giftset_cost'  => 30,
        //         'giftset_price' => 35.5,
        //         'giftset_description' => 'Special Set number 3',
        //         'expires_at'    => '2020-12-22 12:00:00',
        //     ],
        // ];

        // foreach($data as $dataRow) {
        //     App\Giftset::create($dataRow);
        // }
    }
}
