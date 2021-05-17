<?php

namespace App;

use App\Customer;
use App\ExchangeRate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Order extends Model
{
    //
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_number',
        'total_cost',
        'total_price',
        'delivery_fee',
        'grand_total',
        'sale_tax',
        'sale_type',
        'payment_status',
        'delivery_status',
        'payment_method',
        'order_status',
        'customer_id',
        'exchange_rate_id',
    ];

    public $timestamps = true;

    //one to many
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    //one to one
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id', 'order_id');
    }

    //one to one
    public function shippingDetail()
    {
        return $this->hasOne(ShippingDetail::class, 'order_id', 'order_id');
    }

    //many to one
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'promotion_id');
    }
    //many to one
    public function customer()
    {
        return $this->belongsTo(Promotion::class, 'customer_id', 'customer_id');
    }

    /**===============
     * Relationship: one to many
     * table relationship: orders and eschange_rates
     *=================*/
    public function exchangeRates()
    {
        return $this->belongsTo(
            ExchangeRate::class,
            'exchange_rate_id',
        );
    }

    // many to manu 
    /**
     * function to get all sales and quotations
     * @return data of quotation and salse
     */
    public function quotations()
    {
        return $this->hasMany(
            Quotation::class,
            'orders_quotations_bridges',
            'order_id',
            'quotation_id',
        );
    }

    /**
     * function relationship between products and sales 
     * @param product_id, sale_id
     */
    public function product_variants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'orders_product_variants_bridges',
            'order_id',
            'product_variant_id',
        );
    }

    /**
     * sync order stock quantity 
     * @return null
     * @return array $errorMessages
     */
    public function syncStock()
    {
        $orderDetails = $this->orderDetails()->with('productVariant')->get();
        $errorMsg = [];

        //sync quantity
        foreach ($orderDetails as $item) {
            $productVariant = $item->productVariant;
            if (empty($productVariant)) { // empty quantity 
                $errorMsg[$item->id] = "Product Variant ({$item->name}) Not found Or Out of stocks";
            } else if ($productVariant->quantity < $item->quantity) { // oversale  
                $errorMsg[$item->id] = "Insufficient product({$item->name}) in stock. " . $productVariant->quantity . ' in stock and ' . $item->quantity . ' was ordered';
            }
            // else { //sync stock qty
            //     $productVariant = $item->productVariant;
            //     $productVariant->quantity -= $item->quantity;
            // }
        }

        return $errorMsg;
    }

    /**
     * mark order as cancelled
     * 
     * @return boolean
     */
    public function markAsCancelled()
    {
        $this->order_status    = 'cancelled';
        $this->payment_status  = 'cancel';
        $this->delivery_status = 'cancel';

        return $this->update();
    }

    /**
     * mark order as completed
     * 
     * @return boolean
     */
    public function markAsCompleted()
    {
        $this->order_status    = 'completed';
        // $this->payment_status  = 'paid';
        // $this->delivery_status = 'delivered';

        return $this->update();
    }

    /**
     * Check is customer id found
     * @param 
     * @var $customer
     */
    protected static function getCustomers()
    {
        $result = (object)[];
        try {
            $customers = Customer::all();
            $result->data = $customers;
            $result->message = "Customer record found...";
            return $result;
        } catch (ModelNotFoundException $e) {
            $result->data = false;
            $result->message = "There is error when trying to get customer record!";
            return $result;
        }
    }

    //============ HELPER FUNCTION ============

    /**
     * Check validate request
     * @var $referenceNum, $total
     */
    protected static function checkValidateRequest(
        $reference_num,
        $customer_id,
        $order_status,
        $product_id,
        $total_cost,
        $total_price,
        $delivery_fee,
        $grand_total,
        $sale_tax,
        $payment_status,
        $delivery_status,
        $payment_method,
        $exchange_id
    ) {
        $result = (object)[];

        /**
         * Check reference number is true or false
         * @param string $reference_num
         * @return $result
         */
        $reference_num_result = Order::referenceNumber($reference_num);
        if (!$reference_num_result->data) {
            $result->message = $reference_num_result->message;
            return $result;
        }

        /**
         * Check customer is number
         * @param $customer_id
         * @param $total_cost
         * @param $total_price
         * @param $delivery_fee
         * @param $grand_total
         * @param $sale_tax
         * @param $exchange_id
         * @return @result 
         */

        $customer_result = Order::isNumber(
            $customer_id,
            $total_cost,
            $total_price,
            $delivery_fee,
            $grand_total,
            $sale_tax,
            $exchange_id
        );
        if (!$customer_result->data) {
            $result->message = $customer_result->message;
            return $result;
        }

        /**
         * Check order status is valid or not 
         * @param string $order_status
         * @param string $payment_status
         * @param string $delivery_status
         * @param string $payment_method
         * @return $result
         */
        $order_status_result = Order::checkStatuse($order_status, $payment_status, $delivery_status, $payment_method);
        if (!$order_status_result->data) {
            $result->message = $order_status_result->message;
            return $result;
        }

        /**
         * Check customer is exist or not 
         * @param int $customer_id
         * @return $result 
         */
        $customer_result = Order::getCustomer($customer_id);
        if (!$customer_result->data) {
            $result->message = $customer_result->message;
            return $result;
        }

        /**
         * Check product variant is exist or not 
         * @param int $customer_id
         * @return $result 
         */
        $product_variant_result = Order::getProduct($product_id);
        if (!$product_variant_result->data) {
            $result->message = $product_variant_result->message;
            return $result;
        }

        /**
         * Check exchange rate id is exist or not 
         * @param int $exchange_id
         * @return $result 
         */
        $exchange_id_result = Order::getExchangeRate($exchange_id);
        if (!$exchange_id_result->data) {
            $result->message = $exchange_id_result->message;
            return $result;
        }

        $result->data = true;
        $result->message = 'All data are valided!';
    }

    /**
     * Check correct data type of total, paid and customer id.
     * @param string $customer_id
     * @param string $total_cost
     * @param string $total_price
     * @param string $delivery_fee
     * @param string $grand_total
     * @param string $sale_tax
     * @param string $exchange_id
     * @return ObjectRespond [data, message]
     */

    protected static function isNumber(
        $customer_id,
        $total_cost,
        $total_price,
        $delivery_fee,
        $grand_total,
        $sale_tax,
        $exchange_id
    ) {
        $respond = (object)[];
        if (!(is_numeric($customer_id))) {
            $respond->data = false;
            $respond->message = "customer id must be number!";
        } else {
            $respond->data = $customer_id;
            $respond->message = "customer is valid.";
        }

        if (!(is_numeric($total_cost))) {
            $respond->data = false;
            $respond->message = "total cost must be number!";
        } else {
            $respond->data = $total_cost;
            $respond->message = "total cost is valid.";
        }

        if (!(is_numeric($total_price))) {
            $respond->data = false;
            $respond->message = "total price must be number!";
        } else {
            $respond->data = $total_price;
            $respond->message = "total price is valid.";
        }

        if (!(is_numeric($delivery_fee))) {
            $respond->data = false;
            $respond->message = "delivery fee must be number!";
        } else {
            $respond->data = $delivery_fee;
            $respond->message = "delivery feeis valid.";
        }

        if (!(is_numeric($grand_total))) {
            $respond->data = false;
            $respond->message = "grand total must be number!";
        } else {
            $respond->data = $grand_total;
            $respond->message = "grand toatal is valid.";
        }

        if (!(is_numeric($sale_tax))) {
            $respond->data = false;
            $respond->message = "sale tax must be number!";
        } else {
            $respond->data = $sale_tax;
            $respond->message = "sale tax is valid.";
        }

        if (!(is_numeric($exchange_id))) {
            $respond->data = false;
            $respond->message = "exchange rate id must be number!";
        } else {
            $respond->data = $exchange_id;
            $respond->message = "exchange rate id is valid.";
        }
        return $respond;
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
     * Check is valide Quotation status
     * @param string $order_status
     * @param string $payment_status
     * @param string $delivery_status
     * @param string $payment_method
     * @return ObjectRespond [data, message]
     */
    protected static function checkStatuse($order_status, $payment_status, $delivery_status, $payment_method)
    {
        $respond = (object)[];
        if ($order_status != "pending" && $order_status != "confirmed" && $order_status != "completed" && $order_status != "cancelled") {
            $respond->data = false;
            $respond->message = "order status is not valid!";
        } else {
            $respond->data = $order_status;
            $respond->message = "order status is valid.";
        }

        if ($payment_status != "pending" && $payment_status != "partial" && $payment_status != "paid" && $payment_status != "cancel") {
            $respond->data = false;
            $respond->message = "payment status is not valid!";
        } else {
            $respond->data = $payment_status;
            $respond->message = "payment status is valid.";
        }

        if ($delivery_status != "pending" && $delivery_status != "delivering" && $delivery_status != "delivered" && $delivery_status != "cancel") {
            $respond->data = false;
            $respond->message = "delivery status is not valid!";
        } else {
            $respond->data = $delivery_status;
            $respond->message = "delivery status is valid.";
        }

        if ($payment_method != "ABA" && $payment_method != "PIPAY" && $payment_method != "WING" && $payment_method != "TRUE MONEY" && $payment_method != "Cash on Delivery") {
            $respond->data = false;
            $respond->message = "payment method is not valid!";
        } else {
            $respond->data = $payment_method;
            $respond->message = "delivery method is valid.";
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
     * Check product vaiant base on id
     * @param Int $productId
     * @return Model Customer | false
     */

    protected static function getProduct($productId)
    {
        $respond = (object)[];
        try {
            $product = ProductVariant::findOrFail($productId);
            $respond->message = 'Product is found!';
            $respond->data = $product;
        } catch (ModelNotFoundException $e) {
            $respond->data = false;
            $respond->message = 'Product not found';
        }
        return $respond;
    }

    /**
     * Check exchange rate base on id
     * @param Int $exchange_id
     * @return Model Customer | false
     */

    protected static function getExchangeRate($exchange_id)
    {
        $respond = (object)[];
        try {
            $exchange_id = ExchangeRate::findOrFail($exchange_id);
            $respond->message = 'Exchange rate id is found!';
            $respond->data = $exchange_id;
        } catch (ModelNotFoundException $e) {
            $respond->data = false;
            $respond->message = 'Excange rate id not found';
        }
        return $respond;
    }
}
