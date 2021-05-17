<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::beginTransaction();

        $categories = [
            'len'       => new Category(['category_name' => 'len']),
            'lash'      => new Category(['category_name' => 'lash']),
            'accessory' => new Category(['category_name' => 'accessory']),
            //'sunglass' => new Category(['category_name' => 'sunglass']),
        ];

        foreach ($categories as $key => $category) {
            $category->save();
        }

        $size_id = $this->getAttributeId('size');
        $color_id = $this->getAttributeId('color');
        $myopia_id = $this->getAttributeId('myopia');
        // $caseType_id = $this->getAttributeId('case type');
        // $makeType_id = $this->getAttributeId('make type');
        $caseType_id = $this->getAttributeId('case');
        $makeType_id = $this->getAttributeId('make');
        $disposal_id = $this->getAttributeId('disposal');
        $dia_id      = $this->getAttributeId('dia');

        //link category_id to attibute_id
        $categories['lash']
            ->attributes()
            ->attach([
                $makeType_id, 
                $size_id
            ]);

        $categories['len']
            ->attributes()
            ->attach([
                $color_id, 
                $disposal_id, 
                $myopia_id,
                $dia_id,
            ]);

        $categories['accessory']
            ->attributes()
            ->attach([
                $caseType_id, 
                $size_id
            ]);

        DB::commit();
    }

    /**
     * get attribute_id by name
     * @return int attribute_id
     */
    private function getAttributeId(string $attributeName)
    {
        return App\Attribute::where('attribute_name', $attributeName)->value('attribute_id');
    }
}
