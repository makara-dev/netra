<?php

use App\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //     $faker = Faker\Factory::create();

    //     //get Lens product id
    //     $lensName = [
    //         'alley brown',
    //         'alley gray',
    //         'angel star blue',
    //         'angel star gray',
    //         'calypso gray',
    //         'calypso blue',
    //         'charmis brown',
    //         'charmis gray',
    //         'dali gray',
    //         'dali silver',
    //     ];
    //     $lensId = $this->getProductId($lensName);

    //     //get cases product id
    //     $casesName = [
    //         'ប្រអប់ color x1',
    //         'ប្រអប់ color x2',
    //         'ប្រអប់ color x6',
    //         'ប្រអប់ 4 square',
    //         'ប្រអប់ care bear',
    //         'ប្រអប់ angry bird',
    //     ];
    //     $casesId = $this->getProductId($casesName);

    //     //get lashes product id
    //     $lashesName = [
    //         'Bohktoh រោមភ្នែក 10គូ J002',
    //         'Bohktoh រោមភ្នែក 10គូ J004',
    //         'Bohktoh រោមភ្នែក 10គូ P102',
    //         'Bohktoh រោមភ្នែក 10គូ N291',
    //         'Bohktoh រោមភ្នែក 10គូ Y009',
    //     ];
    //     $lashesId = $this->getProductId($lashesName);

    //     //get cleaning solution id
    //     $cleaningSolutionsName = [
    //         'cleaner Y189',
    //         'cleaner M123',
    //         'cleaner S812',
    //     ];
    //     $cleaningSolutionsId = $this->getProductId($cleaningSolutionsName);

    //     $data = [
    //     //lens
    //         //alley brown
    //         [
    //             'product_variant_sku' => 'alley brown 14.2 -0.75 1day',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['alley brown'],
    //         ],
    //         [
    //             'product_variant_sku' => 'alley brown 14.2 -5.00 2weeks',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['alley brown'],
    //         ],
    //         [
    //             'product_variant_sku' => 'alley brown 14.5 -8.50 1month',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['alley brown'],
    //         ],

    //         //alley gray
    //         [
    //             'product_variant_sku' => 'alley gray 14.5 -0.75 2weeks',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['alley gray'],
    //         ],
    //         [
    //             'product_variant_sku' => 'alley gray 14.0 -5.00 1day',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['alley gray'],
    //         ],
    //         [
    //             'product_variant_sku' => 'alley gray 14.2 -5.00 2weeks',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['alley gray'],
    //         ],
            
    //         //angel star blue
    //         [
    //             'product_variant_sku' => 'angel star blue 14.2 -0.75 2weeks',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['angel star blue'],
    //         ],

    //         //angel star gray
    //         [
    //             'product_variant_sku' => 'angel star gray 14.5 -8.50 3months',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['angel star gray'],
    //         ],

    //         //calypso gray
    //         [
    //             'product_variant_sku' => 'calypso gray 14.0 -5.00 1day',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['calypso gray'],
    //         ],
    //         [
    //             'product_variant_sku' => 'calypso gray 14.2 -5.00 1months',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['calypso gray'],
    //         ],

    //         //calypso blue
    //         [
    //             'product_variant_sku' => 'calypso blue 14.0 -0.75 1month',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['calypso blue'],
    //         ],
    //         [
    //             'product_variant_sku' => 'calypso blue 14.5 -8.50 1month',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['calypso blue'],
    //         ],

    //         //charmis brown
    //         [
    //             'product_variant_sku' => 'charmis brown 14.2 -0.75 1day',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['charmis brown'],
    //         ],
    //         [
    //             'product_variant_sku' => 'charmis brown 14.0 -0.75 1month',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['charmis brown'],
    //         ],

    //         //charmis gray
    //         [
    //             'product_variant_sku' => 'charmis gray 14.5 -0.75 1day',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['charmis gray'],
    //         ],
    //         [
    //             'product_variant_sku' => 'charmis gray 14.0 -0.75 1month',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['charmis gray'],
    //         ],

    //         //dali gray
    //         [
    //             'product_variant_sku' => 'dali gray 14.5 -5.00 3months',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['dali gray'],
    //         ],

    //         //dali silver
    //         [
    //             'product_variant_sku' => 'dali silver 14.5 -8.50 1day',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['dali silver'],
    //         ],
    //         [
    //             'product_variant_sku' => 'dali silver 14.0 -8.50 2weeks',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['dali silver'],
    //         ],
    //         [
    //             'product_variant_sku' => 'dali silver 14.0 -8.50 1months',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lensId['dali silver'],
    //         ],

    //     //lashes
    //         // 'Bohktoh រោមភ្នែក 10គូ J002'
    //         [
    //             'product_variant_sku' => 'J002 3d m',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lashesId['Bohktoh រោមភ្នែក 10គូ J002'],
    //         ],
    //         [
    //             'product_variant_sku' => 'J002 glue l',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lashesId['Bohktoh រោមភ្នែក 10គូ J002'],
    //         ],

    //         // 'Bohktoh រោមភ្នែក 10គូ J004'
    //         [
    //             'product_variant_sku' => 'J004 3d l',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lashesId['Bohktoh រោមភ្នែក 10គូ J004'],
    //         ],

    //         // 'Bohktoh រោមភ្នែក 10គូ P102'
    //         [
    //             'product_variant_sku' => 'P102 3d x',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lashesId['Bohktoh រោមភ្នែក 10គូ P102'],
    //         ],

    //         // 'Bohktoh រោមភ្នែក 10គូ N291'
    //         [
    //             'product_variant_sku' => 'N291 3d l',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lashesId['Bohktoh រោមភ្នែក 10គូ N291'],
    //         ],

    //         // 'Bohktoh រោមភ្នែក 10គូ Y009 3d x'
    //         [
    //             'product_variant_sku' => 'Y009 3d x',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $lashesId['Bohktoh រោមភ្នែក 10គូ Y009'],
    //         ],

    //     //accessories [box]
    //         // 'ប្រអប់ color x1'
    //         [
    //             'product_variant_sku' => 'ប្រអប់ color x1 single case m',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $casesId['ប្រអប់ color x1'],
    //         ],
    //         [
    //             'product_variant_sku' => 'ប្រអប់ color x1 mini case l',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $casesId['ប្រអប់ color x1'],
    //         ],

    //         // 'ប្រអប់ color x2'
    //         [
    //             'product_variant_sku' => 'ប្រអប់ color x2 mini case l',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $casesId['ប្រអប់ color x2'],
    //         ],

    //         // 'ប្រអប់ color x6'
    //         [
    //             'product_variant_sku' => 'ប្រអប់ color x6 triple case x',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $casesId['ប្រអប់ color x6'],
    //         ],

    //         // 'ប្រអប់ 4 square'
    //         [
    //             'product_variant_sku' => 'ប្រអប់ 4 square twins case l',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $casesId['ប្រអប់ 4 square'],
    //         ],

    //         // 'ប្រអប់ care bear'
    //         [
    //             'product_variant_sku' => 'ប្រអប់ care bear mini case x',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $casesId['ប្រអប់ care bear'],
    //         ],

    //         // 'ប្រអប់ angry bird'
    //         [
    //             'product_variant_sku' => 'ប្រអប់ angry bird mini case l',
    //             'cost' => $faker->randomFloat(2, 0.00, 5.00),
    //             'price' => $faker->randomFloat(2, 5.00, 10.00),
    //             'quantity' => $faker->randomNumber(2),
    //             'product_id' => $casesId['ប្រអប់ angry bird'],
    //         ],

            
    //     ];

    //     //insert product variants 
    //     foreach($data as $dataRow){
    //         App\ProductVariant::create($dataRow);
    //     }
    }

    /**
     * get the products id into an array.
     *
     * @return array associative array (key = product name, value = product id)
     * 
     */
    // private function getProductId(array $productsName)
    // {
    //     //fill keys
    //     $productsId = array_fill_keys($productsName, null);

    //     //set id value
    //     foreach($productsName as $productName){
    //         $productId = DB::table('products')->where('product_name', $productName)->value('product_id');
    //         $productsId[$productName] = $productId;
    //     }
    //     return $productsId;
    // }
}
