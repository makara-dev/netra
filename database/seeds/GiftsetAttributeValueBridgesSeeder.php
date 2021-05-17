<?php

use App\Giftset;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GiftsetAttributeValueBridgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker\Factory::create();

        // $giftsets = DB::table('giftsets')->select('giftset_id')->get();
        // $attributeValues = DB::table('attribute_values')->pluck('attribute_value_id');

        // foreach($giftsets as $giftset)
        // {
        //     for($i = 0; $i < $faker->numberBetween(1,6); $i++  ){
        //         DB::table('giftset_attrval_bridges')->insert([
        //             'attribute_value_id' => $faker->randomElement($attributeValues),
        //             'giftset_id' => $giftset->giftset_id,
        //         ]);
        //     }
        // }
    }
}
