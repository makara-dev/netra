<?php

use App\Attribute;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
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
            ['attribute_name' => 'color'],
            ['attribute_name' => 'myopia'],
            ['attribute_name' => 'disposal'],
            ['attribute_name' => 'size'],
            // ['attribute_name' => 'make type'],
            // ['attribute_name' => 'case type'],  
            ['attribute_name' => 'make'],
            ['attribute_name' => 'case'],  
            ['attribute_name' => 'dia'],                    
        ];
        foreach($data as $dataRow){
            Attribute::create($dataRow);
        }
    }
}
