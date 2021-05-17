<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\ProductVariant;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ApiProductVariantController extends Controller
{
    /**
     * GET Attributes Linked to Product In CategoryS
     * @return JSON $attribute 
     */
    public function checkStock(Request $request)
    {
        //get product variant
        try {
            $productId = (int) $request->product;
            $product = App\Product::findOrFail($productId);
        } catch (ModelNotFoundException $mne) {
            $response = [
                'Content-type' => 'application/json',
                'status' => 'error',
                'message' => $mne->getMessage(),
            ];
            return response()->json($response);
        }

        //cast attribute value input to an array of ints
        $inputs = $request->attributeValues;

        $productVariant = $product->findProductVariantByAttrVal($inputs);

        if (empty($productVariant) || $productVariant->quantity <= 0) {
            $response = [
                'Content-type' => 'application/json',
                'status' => 'failed',
                'message' => ['out of stock', '0.00'],
            ];
        } else {
            $response = [
                'Content-type' => 'application/json',
                'status' => 'success',
                'message' => ['Available in stock', $productVariant->price],
            ];
        }
        return response()->json($response);
    }

    /**
     * DELETE productvariant
     */
    public function destroy($id)
    {
        try {
            $productVariant = ProductVariant::findOrFail($id);

            if (!$productVariant->delete()) {
                throw new ErrorException('Unable to delete the product variant');
            }

            $response = [
                'status' => 'success',
                'message' => 'Product variant Deleted Successfully',
            ];
        } catch (ModelNotFoundException | ErrorException $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($response);
    }

    /**
     * Custom ajax pagination
     * 
     */
    public function ajaxPagination(Request $request)
  {
    $productVariants = ProductVariant::paginate(10);
  
    if ($request->ajax()) {
        return view('presult', compact('productVariants'));
    }
  
    return view('dashboard.promoset.add',compact('productVariants'));
  }
}
