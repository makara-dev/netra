<?php

use App\Promoset;
use Illuminate\Database\Seeder;

class PromosetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            // argust set 1
            [
                'promoset_name'         => 'argust set 1',
                'promoset_condition'    => '1',
                'provider_condition'    => '1',
                'discount_price_offer'  => null,
                'promoset_thumbnail'    => null,
                'promoset_description'  => 'Testing argust set number 1!',
            ],
        ];

        // seed into database
        foreach($data as $dataRow) {
            Promoset::create($dataRow);
        }
    }
}
