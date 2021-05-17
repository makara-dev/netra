<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PvPurchasePromosetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $data = [
        //     // argust set 1 purchase these product variant [1 day of any lens list above] to get special set
        //     [
        //         'promoset_id'    => 1,
        //         'product_variant_id' => 1,
        //     ],
        //     [
        //         'promoset_id'    => 1,
        //         'product_variant_id' => 5,
        //     ],
        //     [
        //         'promoset_id'    => 1,
        //         'product_variant_id' => 9,
        //     ],
        //     [
        //         'promoset_id'    => 1,
        //         'product_variant_id' => 15,
        //     ],
        // ];

        // // seed into database
        // DB::table('pvpurchase_promoset_bridges')->insert($data);
    }
}
