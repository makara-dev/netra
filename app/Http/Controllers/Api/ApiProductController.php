<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiProductController extends Controller
{
    /**
     * GET Attributes Linked to Product In Category
     * @param int $id - category_id
     * @return JSON $attribute 
     */
    public function getAttributes(int $categoryId)
    {
        //get category
        try {
            $category = App\Category::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            return response()->json($response);
        }

        $attributes = $category->attributes;

        // **** 
        //      sort incorrectly for string of number
        //      desc will correctly sort myopia attribute but cause other to sort desc
        //      while asc will correcly sort other attribute but cuase myopia sort incorrectly 
        // *****
        $attributesWithChildren = $attributes->load('attributeValues'); // old code without sort
        // $attributesWithChildren = $attributes->load(['attributeValues' => function($attributeValue) {
        //     $attributeValue->orderBy('attribute_value', 'desc');
        // }]);


        if ($attributes->count() == 0) {
            $response = [
                'Content-type' => 'application/json',
                'status' => 'error',
                'message' => 'No Attribute In Product',
            ];
        } else {
            $response = [
                'Content-type' => 'application/json',
                'status' => 'success',
                'message' => $attributesWithChildren,
            ];
        }
        return response()->json($response);
    }
}
