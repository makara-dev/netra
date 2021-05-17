<?php
use App\Product;
use App\Category;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        // //get category id
        // $lenCategoryId = $this->selectId('len');
        // $lashCategoryId = $this->selectId('lash');
        // $accessoryCategoryId = $this->selectId('accessory');
        // // $frameCategoryId = $this->selectId('sunglass');

        // // 
        // $data = [];

        // //add lens
        // $this->insertProductName($data, 
        //     $lenCategoryId, 
        //     'alley brown',
        //     'alley gray',
        //     'angel star blue',
        //     'angel star gray',
        //     'calypso gray',
        //     'calypso blue',
        //     'charmis brown',
        //     'charmis gray',
        //     'dali gray',
        //     'dali silver',
        // );

        // //add frames
        // // $this->insertProductName(
        // //     $data, 
        // //     $frameCategoryId, 
        // //     'Prada PR 16MV',
        // //     'Persol PO3050V',
        // //     'Burberry BE1282',
        // //     'Ray-Ban RB2132',
        // //     'Oakley Airdrop'
        // // );

        // //add cases
        // $this->insertProductName(
        //     $data, 
        //     $accessoryCategoryId, 
        //     'ប្រអប់ color x1',
        //     'ប្រអប់ color x2',
        //     'ប្រអប់ color x6',
        //     'ប្រអប់ 4 square',
        //     'ប្រអប់ care bear',
        //     'ប្រអប់ angry bird',
        // );
        
        // //add lashes
        // $this->insertProductName(
        //     $data, 
        //     $lashCategoryId, 
        //     'Bohktoh រោមភ្នែក 10គូ J002',
        //     'Bohktoh រោមភ្នែក 10គូ J004',
        //     'Bohktoh រោមភ្នែក 10គូ P102',
        //     'Bohktoh រោមភ្នែក 10គូ N291',
        //     'Bohktoh រោមភ្នែក 10គូ Y009'
        // );

        // //add cleaning solutions
        // $this->insertProductName(
        //     $data, 
        //     $accessoryCategoryId, 
        //     'cleaner Y189',
        //     'cleaner M123',
        //     'cleaner S812',
        // );
        // //change this later to attribute

        // //seed to database
        // foreach ($data as $dataRow)
        // {
        //     Product::create($dataRow);
        // }
    }

    //get category_id
    // private function selectId(string $CategoryName)
    // {
    //     return Category::where('category_name',$CategoryName)->value('category_id');
    // }

    // //push product name into array
    // private function insertProductName(&$data, $id, ...$productNames)
    // {
    //     foreach($productNames as $productName)
    //     {
    //         $temp =  [
    //             'product_name' => $productName,
    //             'category_id' => $id,
    //         ];
    //         array_push($data, $temp);
    //     }
    // }
   
}
