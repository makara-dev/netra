<?php

namespace App;

use App\Customer;
use App\Sale;
use App\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class Quotation extends Model
{

    /**
     * Table name
     * @var string
     */
    protected $table = 'quotations';

    /**
     * Primary key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Forieg key
     * @var string
     */
    protected $foriegnKey = 'customer_id';

    /**
     * Attribute have to fill in
     * @var array
     */
    protected $fillable = [
        'id',
        'datetime',
        'reference_num',
        'status',
        'total',
        'quotation_note',
        'staff_note',
        'customer_id',
        'exchange_rate_id',
    ];

    /**
     * Check validate request
     * @var $referenceNum, $total
     */
    protected static function checkValidateRequest(
        $referenceNum,
        $total,
        // $pirce,
        // $quantity,
        $customer_id,
        $quotationStatus,
        $exchangerate
    ) {
        $validate = (object)[];

        // reference number allow only number and text
        $referenceNumValidate = Quotation::checkValidStringNbQuot($referenceNum);
        if (!$referenceNumValidate) {
            $validate->message = "Reference number allow only text and number!";
            return $validate;
        }

        // total & customer id must number
        $validTotalNCus = Quotation::checkValidNbQuot($total, $customer_id, $exchangerate);
        if (!$validTotalNCus) {
            $validate->message = "Total and Customer ID should be number!";
            return $validate;
        }

        // check valid status
        $validStatus = Quotation::checkValidQuotationtStatus($quotationStatus);
        if (!$validStatus) {
            $validate->message = "Quotation status not found or incorrect providing!";
            return $validate;
        }

        // is exist customer id
        $isExistCusID = Quotation::isCusFound($customer_id);
        if (!$isExistCusID) {
            $validate->message = "Customer id not found or does not exist!";
            return $validate;
        }

        // calculate total
        // $calculateTotal = Quotation::calculateNetPriceTotal($pirce, $quantity, $total);
        //     if(!$calculateTotal){
        //         $validate->message = "The problem while calculating!";
        //         return $validate;
        //     }
    }

    /**
     * Check correct data type of total, paid and customer id.
     * @param number $total 
     * @param number $customer_id 
     * @return Boolean $result
     */

    protected static function checkValidNbQuot(
        $total,
        $customer_id,
        $exchangerate
    ) {
        if (!is_numeric($total) && !is_numeric($customer_id) && !is_numeric($exchangerate)) {
            return false;
        }
        return true;
    }


    /**
     * Check allow only text and number of reference number.
     * @param string $referenceNum 
     * @param string $text 
     * @return Boolean $result
     */

    protected static function checkValidStringNbQuot($referenceNum)
    {
        if (!(preg_match("/^[a-zA-Z0-9]+$/", $referenceNum) == 1)) {
            return false;
        }
        return true;
    }

    /**
     * Check is valide Quotation status
     * @param string $quotationStatus
     * @return Boolean
     */
    protected static function checkValidQuotationtStatus($quotationStatus)
    {
        if ($quotationStatus != "Pending" && $quotationStatus != "Completed" && $quotationStatus != "Denail") {
            return false;
        }
        return true;
    }

    /**
     * Check is valide Quotation status
     * @param string $customerID
     * @return Boolean
     */
    protected static function isCusFound($customerID)
    {
        if (Customer::where('customer_id',  $customerID)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    // test
    // protected static function calculateNetPriceTotal($pirce, $quantity, $total){
    //     $totalCal = $pirce*$quantity;
    //     if(!( $total==$totalCal)){
    //         return false;
    //     }
    //     return true;
    // }

    /**
     * Check is quotation id found
     * @param id
     * @var $quotation
     */
    public static function getQuotation($id)
    {
        $respond = (object)[];
        try {
            $quotation = Quotation::findOrFail($id);
            $respond->data = $quotation;
            $respond->message = "Quotation record found...";
        } catch (ModelNotFoundException $e) {
            $respond->data = false;
            $respond->message = "There is error when trying to get quotation record!";
        }
        return $respond;
    }

    /**
     * Get all data of quotation
     * @param $result
     * @var $quotation
     */
    protected static function getQuotaions()
    {
        $result = (object)[];
        try {
            $quotations = Quotation::all();
            $result->data = $quotations;
            $result->message = "Quotation record found...";
            return $result;
        } catch (Exception $e) {
            $result->data = false;
            $result->message = "There is error when trying to get quotation record!";
            return $result;
        }
    }

    /**
     * Check is customer id found
     * @param 
     * @var $customer
     */
    protected static function getCustomer()
    {
        $result = (object)[];
        try {
            $customers = Customer::all();
            $result->data = $customers;
            $result->message = "Customer record found...";
            return $result;
        } catch (Exception $e) {
            $result->data = false;
            $result->message = "There is error when trying to get customer record!";
            return $result;
        }
    }

    /**===============
     * Relationship: one to many
     * table relationship: quoation and customer  
     *  Relationships
     *=================*/
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    /**===============
     * Relationship: one to many
     * table relationship: quotation and sale
     *=================*/
    public function productvars()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'quotations_productvars_bridges',
            'quotation_id',
            'product_variant_id'
        );
    }

    /**===============
     * Relationship: one to many
     * table relationship: quotation and products
     *=================*/
    public function sales()
    {
        return $this->hasMany(
            Sale::class,
            'sales_quotations_bridge',
            'quotations_id',
            'sales_id',
        );
    }

    public function orders()
    {
        return $this->hasMany(
            Order::class,
            'orders_quotations_bridges',
            'quotation_id',
            'order_id',
        );
    }
    /**===============
     * Relationship: one to many
     * table relationship: quotation and products
     *=================*/
    public function exchangeRates()
    {
        return $this->belongsTo(
            ExchangeRate::class,
            'exchange_rate_id',
        );
    }
}
