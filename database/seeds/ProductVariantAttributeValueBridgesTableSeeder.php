<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantAttributeValueBridgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //     $data = [
    //     // lens
    //         //alley brown 14.2 -0.75 1day
    //             [
    //                 'product_variant_id' => 1,
    //                 'attribute_value_id' => 1,
    //             ],
    //             [
    //                 'product_variant_id' => 1,
    //                 'attribute_value_id' => 49,
    //             ],
    //             [
    //                 'product_variant_id' => 1,
    //                 'attribute_value_id' => 7,
    //             ],
    //             [
    //                 'product_variant_id' => 1,
    //                 'attribute_value_id' => 34,
    //             ],

    //         //alley brown 14.2 -5.00 2weeks
    //             [
    //                 'product_variant_id' => 2,
    //                 'attribute_value_id' => 1,
    //             ],
    //             [
    //                 'product_variant_id' => 2,
    //                 'attribute_value_id' => 49,
    //             ],
    //             [
    //                 'product_variant_id' => 2,
    //                 'attribute_value_id' => 23,
    //             ],
    //             [
    //                 'product_variant_id' => 2,
    //                 'attribute_value_id' => 35,
    //             ],

    //         //alley brown 14.5 -8.50 1month
    //             [
    //                 'product_variant_id' => 3,
    //                 'attribute_value_id' => 1,
    //             ],
    //             [
    //                 'product_variant_id' => 3,
    //                 'attribute_value_id' => 50,
    //             ],
    //             [
    //                 'product_variant_id' => 3,
    //                 'attribute_value_id' => 30,
    //             ],
    //             [
    //                 'product_variant_id' => 3,
    //                 'attribute_value_id' => 36,
    //             ],

    //         //alley gray 14.2 -5.00 2weeks
    //             [
    //                 'product_variant_id' => 4,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 6,
    //                 'attribute_value_id' => 49,
    //             ],
    //             [
    //                 'product_variant_id' => 4,
    //                 'attribute_value_id' => 23,
    //             ],
    //             [
    //                 'product_variant_id' => 4,
    //                 'attribute_value_id' => 35,
    //             ],

    //         //alley gray 14.0 -5.00 1day
    //             [
    //                 'product_variant_id' => 5,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 6,
    //                 'attribute_value_id' => 48,
    //             ],
    //             [
    //                 'product_variant_id' => 5,
    //                 'attribute_value_id' => 23,
    //             ],
    //             [
    //                 'product_variant_id' => 5,
    //                 'attribute_value_id' => 34,
    //             ],

    //         //alley gray 14.5 -0.75 2weeks
    //             [
    //                 'product_variant_id' => 6,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 6,
    //                 'attribute_value_id' => 50,
    //             ],
    //             [
    //                 'product_variant_id' => 6,
    //                 'attribute_value_id' => 7,
    //             ],
    //             [
    //                 'product_variant_id' => 6,
    //                 'attribute_value_id' => 35,
    //             ],

    //         //angel star blue 14.2 -0.75 2weeks
    //             [
    //                 'product_variant_id' => 7,
    //                 'attribute_value_id' => 2,
    //             ],
    //             [
    //                 'product_variant_id' => 7,
    //                 'attribute_value_id' => 49,
    //             ],
    //             [
    //                 'product_variant_id' => 7,
    //                 'attribute_value_id' => 7,
    //             ],
    //             [
    //                 'product_variant_id' => 7,
    //                 'attribute_value_id' => 35,
    //             ],

    //         //angel star gray 14.5 -8.50 3months
    //             [
    //                 'product_variant_id' => 8,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 8,
    //                 'attribute_value_id' => 50,
    //             ],
    //             [
    //                 'product_variant_id' => 8,
    //                 'attribute_value_id' => 30,
    //             ],
    //             [
    //                 'product_variant_id' => 8,
    //                 'attribute_value_id' => 37,
    //             ],

    //         //calypso gray 14.0 -5.00 1day
    //             [
    //                 'product_variant_id' => 9,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 9,
    //                 'attribute_value_id' => 48,
    //             ],
    //             [
    //                 'product_variant_id' => 9,
    //                 'attribute_value_id' => 23,
    //             ],
    //             [
    //                 'product_variant_id' => 9,
    //                 'attribute_value_id' => 34,
    //             ],

    //         //calypso gray 14.2 -5.00 1month
    //             [
    //                 'product_variant_id' => 10,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 10,
    //                 'attribute_value_id' => 49,
    //             ],
    //             [
    //                 'product_variant_id' => 10,
    //                 'attribute_value_id' => 23,
    //             ],
    //             [
    //                 'product_variant_id' => 10,
    //                 'attribute_value_id' => 36,
    //             ],

    //         //calypso blue 14.5 -8.50 1month
    //             [
    //                 'product_variant_id' => 11,
    //                 'attribute_value_id' => 2,
    //             ],
    //             [
    //                 'product_variant_id' => 11,
    //                 'attribute_value_id' => 50,
    //             ],
    //             [
    //                 'product_variant_id' => 11,
    //                 'attribute_value_id' => 30,
    //             ],
    //             [
    //                 'product_variant_id' => 11,
    //                 'attribute_value_id' => 36,
    //             ],

    //         //calypso blue 14.0 -0.75 1month
    //             [
    //                 'product_variant_id' => 12,
    //                 'attribute_value_id' => 2,
    //             ],
    //             [
    //                 'product_variant_id' => 12,
    //                 'attribute_value_id' => 48,
    //             ],
    //             [
    //                 'product_variant_id' => 12,
    //                 'attribute_value_id' => 7,
    //             ],
    //             [
    //                 'product_variant_id' => 12,
    //                 'attribute_value_id' => 36,
    //             ],

    //         //charmis brown 14.2 -0.75 1day
    //             [
    //                 'product_variant_id' => 13,
    //                 'attribute_value_id' => 1,
    //             ],
    //             [
    //                 'product_variant_id' => 13,
    //                 'attribute_value_id' => 49,
    //             ],
    //             [
    //                 'product_variant_id' => 13,
    //                 'attribute_value_id' => 7,
    //             ],
    //             [
    //                 'product_variant_id' => 13,
    //                 'attribute_value_id' => 34,
    //             ],

    //         //charmis brown 14.0 -0.75 1month
    //             [
    //                 'product_variant_id' => 14,
    //                 'attribute_value_id' => 1,
    //             ],
    //             [
    //                 'product_variant_id' => 14,
    //                 'attribute_value_id' => 48,
    //             ],
    //             [
    //                 'product_variant_id' => 14,
    //                 'attribute_value_id' => 7,
    //             ],
    //             [
    //                 'product_variant_id' => 14,
    //                 'attribute_value_id' => 36,
    //             ],

    //         //charmis gray 14.5 -0.75 1day
    //             [
    //                 'product_variant_id' => 15,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 15,
    //                 'attribute_value_id' => 50,
    //             ],
    //             [
    //                 'product_variant_id' => 15,
    //                 'attribute_value_id' => 7,
    //             ],
    //             [
    //                 'product_variant_id' => 15,
    //                 'attribute_value_id' => 34,
    //             ],

    //         //charmis gray 14.0 -0.75 1month
    //             [
    //                 'product_variant_id' => 16,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 16,
    //                 'attribute_value_id' => 48,
    //             ],
    //             [
    //                 'product_variant_id' => 16,
    //                 'attribute_value_id' => 7,
    //             ],
    //             [
    //                 'product_variant_id' => 16,
    //                 'attribute_value_id' => 36,
    //             ],

    //         //dali gray 14.5 -5.00 3months
    //             [
    //                 'product_variant_id' => 17,
    //                 'attribute_value_id' => 3,
    //             ],
    //             [
    //                 'product_variant_id' => 17,
    //                 'attribute_value_id' => 50,
    //             ],
    //             [
    //                 'product_variant_id' => 17,
    //                 'attribute_value_id' => 23,
    //             ],
    //             [
    //                 'product_variant_id' => 17,
    //                 'attribute_value_id' => 37,
    //             ],

    //         //dali silver 14.5 -8.50 1day
    //             [
    //                 'product_variant_id' => 18,
    //                 'attribute_value_id' => 4,
    //             ],
    //             [
    //                 'product_variant_id' => 18,
    //                 'attribute_value_id' => 50,
    //             ],
    //             [
    //                 'product_variant_id' => 18,
    //                 'attribute_value_id' => 30,
    //             ],
    //             [
    //                 'product_variant_id' => 18,
    //                 'attribute_value_id' => 34,
    //             ],

    //         //dali silver 14.0 -8.50 2weeks
    //             [
    //                 'product_variant_id' => 19,
    //                 'attribute_value_id' => 4,
    //             ],
    //             [
    //                 'product_variant_id' => 19,
    //                 'attribute_value_id' => 48,
    //             ],
    //             [
    //                 'product_variant_id' => 19,
    //                 'attribute_value_id' => 30,
    //             ],
    //             [
    //                 'product_variant_id' => 19,
    //                 'attribute_value_id' => 35,
    //             ],
            
    //         //dali silver 14.0 -8.50 1month
    //             [
    //                 'product_variant_id' => 20,
    //                 'attribute_value_id' => 4,
    //             ],
    //             [
    //                 'product_variant_id' => 20,
    //                 'attribute_value_id' => 48,
    //             ],
    //             [
    //                 'product_variant_id' => 20,
    //                 'attribute_value_id' => 30,
    //             ],
    //             [
    //                 'product_variant_id' => 20,
    //                 'attribute_value_id' => 36,
    //             ],

    //     // lashes
    //         // 'Bohktoh រោមភ្នែក 10គូ J002 3d m'
    //         [
    //             'product_variant_id' => 21,
    //             'attribute_value_id' => 41,
    //         ],
    //         [
    //             'product_variant_id' => 21,
    //             'attribute_value_id' => 39,
    //         ],
            
    //         // 'Bohktoh រោមភ្នែក 10គូ J002 glue l'
    //         [
    //             'product_variant_id' => 22,
    //             'attribute_value_id' => 42,
    //         ],
    //         [
    //             'product_variant_id' => 22,
    //             'attribute_value_id' => 40,
    //         ],

    //         // 'Bohktoh រោមភ្នែក 10គូ J004 3d l'
    //         [
    //             'product_variant_id' => 23,
    //             'attribute_value_id' => 41,
    //         ],
    //         [
    //             'product_variant_id' => 23,
    //             'attribute_value_id' => 40,
    //         ],

    //         // 'Bohktoh រោមភ្នែក 10គូ P102 3d x'
    //         [
    //             'product_variant_id' => 24,
    //             'attribute_value_id' => 41,
    //         ],
    //         [
    //             'product_variant_id' => 24,
    //             'attribute_value_id' => 38,
    //         ],

    //         // 'Bohktoh រោមភ្នែក 10គូ N291 3d l'
    //         [
    //             'product_variant_id' => 25,
    //             'attribute_value_id' => 41,
    //         ],
    //         [
    //             'product_variant_id' => 25,
    //             'attribute_value_id' => 40,
    //         ],

    //         // 'Bohktoh រោមភ្នែក 10គូ Y009 3d x'
    //         [
    //             'product_variant_id' => 26,
    //             'attribute_value_id' => 41,
    //         ],
    //         [
    //             'product_variant_id' => 26,
    //             'attribute_value_id' => 38,
    //         ],

    //     // accessories [box]
    //         // 'ប្រអប់ color x1 single case m'
    //         [
    //             'product_variant_id' => 27,
    //             'attribute_value_id' => 45,
    //         ],
    //         [
    //             'product_variant_id' => 27,
    //             'attribute_value_id' => 39,
    //         ],

    //         // 'ប្រអប់ color x1 mini case l'
    //         [
    //             'product_variant_id' => 28,
    //             'attribute_value_id' => 44,
    //         ],
    //         [
    //             'product_variant_id' => 28,
    //             'attribute_value_id' => 40,
    //         ],

    //         // 'ប្រអប់ color x2 mini case l'
    //         [
    //             'product_variant_id' => 29,
    //             'attribute_value_id' => 44,
    //         ],
    //         [
    //             'product_variant_id' => 29,
    //             'attribute_value_id' => 40,
    //         ],

    //         // 'ប្រអប់ color x6 triplet case x'
    //         [
    //             'product_variant_id' => 30,
    //             'attribute_value_id' => 47,
    //         ],
    //         [
    //             'product_variant_id' => 30,
    //             'attribute_value_id' => 38,
    //         ],

    //         // 'ប្រអប់ 4 square twins case l'
    //         [
    //             'product_variant_id' => 31,
    //             'attribute_value_id' => 46,
    //         ],
    //         [
    //             'product_variant_id' => 31,
    //             'attribute_value_id' => 40,
    //         ],

    //         // 'ប្រអប់ care bear mini case x'
    //         [
    //             'product_variant_id' => 32,
    //             'attribute_value_id' => 44,
    //         ],
    //         [
    //             'product_variant_id' => 32,
    //             'attribute_value_id' => 38,
    //         ],

    //         // 'ប្រអប់ angry bird mini case l'
    //         [
    //             'product_variant_id' => 33,
    //             'attribute_value_id' => 44,
    //         ],
    //         [
    //             'product_variant_id' => 33,
    //             'attribute_value_id' => 40,
    //         ],


    //     ];

    //     DB::table('productvariant_attributevalue_bridge')->insert($data);
    }
}
