<?php

namespace App\Http\Controllers;

use App;
use Exception;
use Throwable;
use App\ProductVariant;
use App\CustomCart\CustomCart as Cart; // extend Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;

class CartController extends Controller
{
    /**
     * Add Product Variant To Cart
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //filter request to get only Attribute Value inputs
        // output : associative array
        // Ex : ['color' => 1]
        $attributeValueInputs = array_diff_key(
            $request->all(),
            [
                '_token'   => '',
                'quantity' => '',
                'product'  => '',
                'prAttr1'  => '',
                'prAttr2'  => '',
            ] 
        );

        //get product
        try {
            $id = $request->input('product');
            $product = App\Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $productVariant = $product->findProductVariantByAttrVal($attributeValueInputs);

        $quantity = $request->input('quantity');

        if (empty($productVariant)) {
            return back()->with('error', 'Sorry, We dont have this in stock.');
        }

        if (!Cart::checkCartQuantity($quantity, $productVariant)) {
            return back()->with('error', 'Sorry, There is only ' . $productVariant->quantity . ' of the selected item in stock ');
        }

        Cart::add([
            'id' => $productVariant->product_variant_id,
            'name' => $product->product_name,
            'qty' => $quantity,
            'price' => $productVariant->price
        ]);

        Cart::storeCustomerCart();
        return back()->with('success', 'Item Added To Cart Successfully.');
    }

    /**
     * update item quantity in cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        //get product variant
        try {
            $id = $request->input('id');
            $productVariant = ProductVariant::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Product Not Found.");
        } catch (Throwable | Exception $e) {
            return back()->with('error', "Something went wrong while trying to find product.");
        }

        //check quantity in stock
        $quantity = (int) $request->input('quantity');
        if ($quantity > $productVariant->quantity) {
            return back()->with('error', "Sorry, There is only {$productVariant->quantity} of " . ucfirst($productVariant->product->product_name) . " left in stock");
        }

        //update cart
        $rowId = $request->input('rowId');
        Cart::update($rowId, $quantity);
        return back()->with('success', 'Item Quantity Updated.');
    }

    /**
     * Delete item from cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        try {
            Cart::remove($rowId);
            Cart::storeCustomerCart();
        } catch (InvalidRowIDException $e) {
            return back()->with('error', 'Sorry, Something Went Wrong. We can\'t find the specified product.');
        }
        return back()->with('success', 'Item Removed');
    }
}
