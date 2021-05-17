<?php

namespace App;

use App\Quotation;
use App\Customer;
use App\Product;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Sale extends Model
{
    /**
     * Table name.
     * @var String
     */
    protected $table = 'sales';

    /**
     * Primary key.
     * @var String
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that are must assignable.
     * @var Array
     */
    protected $fillable = [
        'id',
        'datetime',
        'reference_num',
        'sale_status',
        'payment_status',
        'total',
        'paid',
        'sale_note',
        'staff_note',
        'customer_id',

    ];

    /**===================
     *  Helper Functions
     *====================*/

    /**
     * validation request data 
     * @param $reference_num
     * @param $sale_status
     * @param $payment_status
     * @param $total
     * @param $paid
     * @param $customer_id
     * @return [data: result_data, message: result_message]
     */

    public static function checkRequestValidation(
        $reference_num,
        $sale_status,
        $payment_status,
        $total,
        $paid,
        $customer_id
    ) {
        $result = (object)[];
        /**
         * Check reference number is true or false
         * @param string $reference_num
         * @return $result
         */
        $reference_num_result = Sale::referenceNumber($reference_num);
        if (!$reference_num_result->data) {
            $result->message = $reference_num_result->message;
            // $result->message = "Reference number value is invalid!";
            return $result;
        }

        /**
         * Check sale status is true or false
         * @param string $sale_status
         * @return $result 
         */
        $sale_status_result = Sale::saleStatus($sale_status);
        if (!$sale_status_result->data) {
            $result->message = $sale_status_result->message;
            // $result->message = "Sale statuse value invalid or incorrect providing!";
            return $result;
        }

        /**
         * Check payment status is true or false
         * @param string $payment_status
         * @return $result 
         */
        $payment_status_result = Sale::paymentStatus($payment_status);
        if (!$payment_status_result->data) {
            $result->message = $payment_status_result->message;
            // $result->message = "Payment statuse value invalid or incorrect providing!";
            return $result;
        }

        /**
         * Check total is true or false
         * @param int $total
         * @return $result 
         */
        $total_result = Sale::isNumber($total);
        if (!$total_result->data) {
            $result->message = $total_result->message;
            // $result->message = "Total should be number!";
            return $result;
        }

        /**
         * Check paid is true or false
         * @param int $paid
         * @return $result 
         */
        $paid_result = Sale::isNumber($paid);
        if (!$paid_result->data) {
            $result->message = $paid_result->message;
            // $result->message = "Paid should be number!";
            return $result;
        }

        /**
         * Compare betweent total and paid paid is true or false
         * @param int $total, $paid
         * @return $result 
         */
        $total_compare_result = Sale::totalPaidComparation($total, $paid);
        if (!$total_compare_result->data) {
            $result->message = $total_compare_result->message;
            // $result->message = "Paid should smaller or equalt to total!";
            return $result;
        }

        /**
         * Check customer is exist or not 
         * @param int $customer_id
         * @return $result 
         */
        $customer_result = Sale::getCustomer($customer_id);
        if (!$customer_result->data) {
            $result->message = $customer_result->message;
            return $result;
        }

        $result->data = true;
        $result->message = 'All data are valided!';
    }

    /**
     * Check reference num is correct format or not 
     * @param string $reference_num
     * @return ObjectRespond [data, message]
     */
    protected static function referenceNumber($reference_num)
    {
        $respond = (object)[];
        if (!(preg_match("/^[a-zA-Z0-9]+$/", $reference_num) == 1)) {
            $respond->data = false;
            $respond->message = "Reference number value is invalid!";
        } else {
            $respond->data = $reference_num;
            $respond->message = "Reference number valid";
        }
        return $respond;
    }

    /**
     * Check sale status is correct format or not 
     * @param string $sale_status
     * @return ObjectRespond [data, message]
     */
    protected static function saleStatus($sale_status)
    {
        $respond = (object)[];
        if ($sale_status != 'Pending' && $sale_status != 'Complete' && $sale_status != 'Denial') {
            $respond->data = false;
            $respond->message = "Sale statuse value invalid or incorrect providing!";
        } else {
            $respond->data = $sale_status;
            $respond->message = "Sale status is valid";
        }
        return $respond;
    }

    /**
     * Check payment status 
     * @param $payment_status
     * @return ObjectRespond [data, message]
     */
    protected static function paymentStatus($payment_status)
    {
        $respond = (object)[];
        if ($payment_status != 'Due' && $payment_status != 'Paid' && $payment_status != 'Denial') {
            $respond->data = false;
            $respond->message = "Payment statuse value invalid or incorrect providing!";
        } else {
            $respond->data = $payment_status;
            $respond->message = "Payment status is valid";
        }
        return $respond;
    }

    /**
     * Check total and paid 
     * @param $tp
     * @return ObjectRespond [data, message]
     */
    protected static function isNumber($tp)
    {
        $respond = (object)[];
        if (!(is_numeric($tp))) {
            $respond->data = false;
            $respond->message = "Total and paid should be number!";
        } else {
            $respond->data = $tp;
            $respond->message = "Value is valid";
        }
        return $respond;
    }

    /**
     * Compare total and paid
     * @param int $total, $paid
     * @return ObjectRespond [data, message]
     */
    protected static function totalPaidComparation($total, $paid)
    {
        $respond = (object)[];
        if ($total < $paid) {
            $respond->data = false;
            $respond->message = "Paid should smaller or equal to total!";
        } else {
            $respond->data = $paid;
            $respond->message = "Value is valid";
        }
        return $respond;
    }

    /**
     * Check customer base on id
     * @param Int $customerId
     * @return Model Customer | false 
     */

    protected static function getCustomer($customerId)
    {
        $respond = (object)[];
        try {
            $customer = Customer::findOrFail($customerId);
            $respond->message = 'Customer is found!';
            $respond->data = $customer;
        } catch (ModelNotFoundException $e) {
            $respond->data = false;
            $respond->message = 'Customer not found';
        }
        return $respond;
    }

    /**
     * get all sale 
     * @return Model Sale : fales
     */

    public static function getSales()
    {
        $respond = (object)[];
        try {
            $slaes = Sale::all();
            $respond->data = $slaes;
            $respond->message = 'Sale is found.';
        } catch (Exception $e) {
            $respond->data = false;
            $respond->message = 'There is a problelm while trying to get sale record or missing migration!';
        }
        return $respond;
    }

    /**
     * get spacific sale 
     * @param int $id 
     * @return Model Sale | false 
     */

    public static function getSale($id)
    {
        $respond = (object)[];
        try {
            $slaes = Sale::findOrFail($id);
            $respond->data = $slaes;
            $respond->message = 'Sale is found.';
        } catch (ModelNotFoundException $e) {
            $respond->data = false;
            $respond->message = 'There is a problelm while trying to get sale record or missing migration!';
        }
        return $respond;
    }

    /**
     * get all customer 
     * @return Model Customer | false 
     */

    public static function getCustomers()
    {
        $respond = (object)[];
        try {
            $customers = Customer::all();
            $respond->data = $customers;
            $respond->message = 'Customers are found';
        } catch (Exception $e) {
            $respond->data = false;
            $respond->message = 'There is a problelm while trying to get customer record or missing migration!';
        }
        return $respond;
    }

    /**
     * get all customer 
     * @return Model Product | false 
     */
    public static function getProducts(){
        $respond = (object)[];
        try{
            $products = Product::all();
            $respond->data = $products;
            $respond->message = "Product found";
        }catch(Exception $e){
            $respond->data = false;
            $respond->message = "Products not found!";
        }
        return $respond;
    }


    /**===============
     *  Relationships
     *=================*/


    /**
     * function to get all sales and quotations
     * @return data of quotation and salse
     */
    public function quotations()
    {
        return $this->hasMany(
            Quotation::class,
            'sales_quotations_bridge',
            'sales_id',
            'quotations_id',
        );
    }

    /**
     * function relationship between products and sales 
     * @param product_id, sale_id
     */
    public function products()
    {
        return $this->hasMany(
            Product::class,
            'sales_products_bridge',
            'sale_id',
            'product_id',
        );
    }
}
