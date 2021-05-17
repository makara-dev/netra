<?php

namespace App\CustomCart;

use App\OrderDetail;
use App\ProductVariant;
use ErrorException;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomCart extends Cart
{
    /**
     * check cart if item qty exceed that of database quantity
     */
    public static function checkCartQuantity(int $inputQty, ProductVariant $productVariant)
    {
        $cartItem = self::getCartItem($productVariant->product_variant_id);

        $inStockQty = $productVariant->quantity;

        if (empty($cartItem)) { //new item to cart
            return ($inputQty <= $inStockQty);
        } else {  //compare current (cart qty + user updated) quantity to stock qty
            $totalCartQty = $inputQty + $cartItem->qty;
            return $totalCartQty <= $inStockQty ;
        }
    }

    /**
     * get cart item from product variant
     */
    public static function getCartItem($productVariantId)
    {
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $productVariantId) {
                return $cartItem;
            }
        }
        return null;
    }

    /**
     * store the current cart session if user is logged in
     */
    public static function storeCustomerCart()
    {
        if (
            auth()->check()
            && !empty(auth()->user()->customer)
        ) {
            $customerId = auth()->user()->customer->customer_id;
            Cart::store($customerId);
            return true;
        }
        return false;
    }

    /**
     * get all productvariants in cart
     * @return Illuminate\Database\Eloquent\Collection ProductVariant[]
     */
    public static function getProductVariants()
    {
        $productVariants = new Collection();

        //get productVariants from cart
        try {
            foreach (Cart::content() as $item) {
                $temp = ProductVariant::find($item->id);
                $temp->quantity = $item->qty;
                $temp->rowId = $item->rowId;
                $productVariants->add($temp);
            }
        } catch (ModelNotFoundException $e) {
            Cart::destroy();
        }

        return $productVariants;
    }

    /**
     * get all productvariants in cart
     * @return Collection ProductVariant[]
     */
    public static function getProductVariantsWithAttrName()
    {
        $productVariants = new Collection();
        try {
            foreach (Cart::content() as $item) {
                $temp = ProductVariant::findOrFail($item->id);
                $temp->quantity = $item->qty;
                $temp->rowId = $item->rowId;

                //get attribute value name except color
                $attrValsName = array_reduce(
                    $temp->attributeValues()->pluck('attribute_value')->toArray(),
                    function ($string, $name) {
                        return $string .= $name . ', ';
                    }
                );
                $attrValsName = rtrim($attrValsName, ", "); //remove last comma

                $temp->name = $temp->product->product_name;
                $temp->properties = "[{$attrValsName}]";
                $temp->thumbnail = $temp->product->thumbnail;

                $productVariants->add($temp);
            }
        } catch (ModelNotFoundException $e) {
            Cart::destroy();
        }

        return $productVariants;
    }

    /**
     * get total cost
     * @return int $totalCost 
     */
    public static function getTotalCost()
    {
        $productsVariantsId = Cart::content()->pluck('id');
        return ProductVariant::whereIn('product_variant_id', $productsVariantsId)->sum('product_variants.cost');
    }

    /**
     * get total price
     * @return int $totalPrice 
     */
    public static function getTotalPrice()
    {
        $productsVariantsId = Cart::content()->pluck('id');
        return ProductVariant::whereIn('product_variant_id', $productsVariantsId)->sum('product_variants.price');
    }

    /**
     * generate a colletion of order_detail objects
     * @return Illuminate\Database\Eloquent\Collection| ProductVariant[]
     */
    public static function generateOrderDetails()
    {
        $productsVariants   = self::getProductVariants();
        if ($productsVariants->isEmpty()) {
            throw new ErrorException('No product found');
        }
        $thumbnail = $productsVariants->first()->product()->value('thumbnail');
        $orderDetails = new Collection();
        foreach ($productsVariants as $item) {
            $tmp = new OrderDetail([
                'thumbnail' => $thumbnail,
                'name'      => $item->product_variant_sku,
                'cost'      => $item->cost,
                'price'     => $item->price,
                'quantity'  => $item->quantity,
            ]);
            $tmp->productVariant()->associate($item);
            $orderDetails->add($tmp);
        }
        return $orderDetails;
    }
}
