<?php

use App\Attribute;
use App\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class AttributeValuesTableSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizeId = $this->getAttributeId('size');
        $colorId = $this->getAttributeId('color');
        $myopiaId = $this->getAttributeId('myopia');
        $disposalId = $this->getAttributeId('disposal');
        // $makeTypeId = $this->getAttributeId('make type');
        // $caseTypeId = $this->getAttributeId('case type');
        $makeTypeId = $this->getAttributeId('make');
        $caseTypeId = $this->getAttributeId('case');   
        $diaId = $this->getAttributeId('dia');     

        //push ALL attributes into an array
        $data = [];

        //Color
        $colorAttributeValues = $this->colorAttributes($colorId);
        $this->pushAttributeInto($data, $colorAttributeValues);

         //myopia
        $myopiaAttributeValues = $this->myopiaAttributes($myopiaId);
        $this->pushAttributeInto($data, $myopiaAttributeValues);

         //disposal
        $disposalAttributeValues = $this->disposalAttributes($disposalId);
        $this->pushAttributeInto($data, $disposalAttributeValues);

        //size
        $sizeAttributeValues = $this->sizeAttributes($sizeId);
        $this->pushAttributeInto($data, $sizeAttributeValues);

        //make type
        $makeTypeAttributeValues = $this->makeTypeAttributes($makeTypeId);
        $this->pushAttributeInto($data, $makeTypeAttributeValues);

        //case type
        $caseTypeAttributeValues = $this->caseTypeAttributes($caseTypeId);
        $this->pushAttributeInto($data, $caseTypeAttributeValues);

        //dia
        $diaAttributeValues = $this->diaAttributes($diaId);
        $this->pushAttributeInto($data, $diaAttributeValues);

        //insert into database
        foreach($data as $dataRow)
        {
            AttributeValue::create($dataRow);
        }
    }

    private function getAttributeId(string $attribute)
    {
        $attributeRow = Attribute::select('attribute_id')->where('attribute_name', $attribute)->first();
        return $attributeRow->attribute_id;
    }

    private function attributeRow(string $attributeValue, int $id)
    {
        return array(
            'attribute_value' => $attributeValue,
            'attribute_id' => $id
        );
    }

    private function pushAttributeInto(&$data, $attributeRows)
    {
        foreach ($attributeRows as $attributeRow) {
            array_push($data, $attributeRow);
        }
    }
    
    private function colorAttributes($colorId)
    {
        return array(
            $this->attributeRow('ash', $colorId),
            $this->attributeRow('amber', $colorId),
            $this->attributeRow('aqua', $colorId),
            $this->attributeRow('brown', $colorId),
            $this->attributeRow('blue', $colorId),
            $this->attributeRow('black', $colorId),
            $this->attributeRow('choco', $colorId),
            $this->attributeRow('cacao', $colorId),
            $this->attributeRow('gray', $colorId),
            $this->attributeRow('gold', $colorId),
            $this->attributeRow('green', $colorId),
            $this->attributeRow('pink', $colorId),
            $this->attributeRow('purple', $colorId),
            $this->attributeRow('red', $colorId),
            $this->attributeRow('sepia', $colorId),
            $this->attributeRow('violet', $colorId),
            $this->attributeRow('yellow', $colorId),
        );
    }
    private function myopiaAttributes($myopiaId)
    {
        return array(
            $this->attributeRow('0.00', $myopiaId),
            $this->attributeRow('-0.50', $myopiaId),
            $this->attributeRow('-0.75', $myopiaId),
            $this->attributeRow('-1.00', $myopiaId),
            $this->attributeRow('-1.25', $myopiaId),
            $this->attributeRow('-1.50', $myopiaId),
            $this->attributeRow('-1.75', $myopiaId),
            $this->attributeRow('-2.00', $myopiaId),
            $this->attributeRow('-2.25', $myopiaId),
            $this->attributeRow('-2.50', $myopiaId),
            $this->attributeRow('-2.75', $myopiaId),
            $this->attributeRow('-3.00', $myopiaId),
            $this->attributeRow('-3.25', $myopiaId),
            $this->attributeRow('-3.50', $myopiaId),
            $this->attributeRow('-3.75', $myopiaId),
            $this->attributeRow('-4.00', $myopiaId),
            $this->attributeRow('-4.25', $myopiaId),
            $this->attributeRow('-4.50', $myopiaId),
            $this->attributeRow('-4.75', $myopiaId),
            $this->attributeRow('-5.00', $myopiaId),
            $this->attributeRow('-5.50', $myopiaId),
            $this->attributeRow('-6.00', $myopiaId),
            $this->attributeRow('-6.50', $myopiaId),
            $this->attributeRow('-7.00', $myopiaId),
            $this->attributeRow('-7.50', $myopiaId),
            $this->attributeRow('-8.00', $myopiaId),
            $this->attributeRow('-8.50', $myopiaId),
            $this->attributeRow('-9.00', $myopiaId),
            $this->attributeRow('-9.50', $myopiaId),
            $this->attributeRow('-10.00', $myopiaId),
        );
    }

    private function disposalAttributes($disposalId)
    {
        return array(
            $this->attributeRow('1 day', $disposalId),
            $this->attributeRow('2 weeks', $disposalId),
            $this->attributeRow('1 month', $disposalId),
            $this->attributeRow('3 months', $disposalId),
        );
    }

    private function sizeAttributes($sizeId){
        return array(
            $this->attributeRow('S', $sizeId),
            $this->attributeRow('M', $sizeId),
            $this->attributeRow('L', $sizeId),
            $this->attributeRow('1 Size', $sizeId),
        );
    }

    private function makeTypeAttributes($makeTypeId){
        return array(
            $this->attributeRow('3D', $makeTypeId),
            $this->attributeRow('glue', $makeTypeId),
            $this->attributeRow('10 Pairs', $makeTypeId),
            $this->attributeRow('hand made', $makeTypeId),
        );
    }

    private function caseTypeAttributes($caseTypeId){
        return array(
            $this->attributeRow('one size case', $caseTypeId),
        );
    }

    private function diaAttributes($diaId){
        return array(
            $this->attributeRow('14.0', $diaId),
            $this->attributeRow('14.2', $diaId),
            $this->attributeRow('14.5', $diaId),
        );
    }

}
