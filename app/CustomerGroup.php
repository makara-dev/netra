<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;
use App\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerGroup extends Model
{
     /**
     * Table name.
     * @var String
     */
    protected $table = 'customer_groups';

    /**
     * Primary key.
     * @var String
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that are mass assignable.
     * @var Array
     */
    protected $fillable = [
        'name',
        'discount',

    ];

    /**
     * Get all customer group from database
     * @return ResponObject [ data: result_data, messange:result_messange ]
     * @param String $name
     * @param Int $discount
     * @param Int $customer_id
     */
    protected static function checkValidateRequest(
        $name,
        $discount,
        $customer_id
    ) {
        $validate = (object)[];

        // check is customer id exist
        if($customer_id != null ){
            $isExistCusID = CustomerGroup::checkCustomerIdExist($customer_id);
            if (!$isExistCusID) {
                $validate->message = "Customer id not found or does not exist!";
                return $validate;
            }
        }

        // validate name and discount is a number
        $isNumeric = CustomerGroup::checkValidQPC($name, $discount);
        if (!$isNumeric) {
            $validate->message = "Quantity, Discount should be number and Name of customer group should be string!";
            return $validate;
        }

        // check discount percentage should not be more than 100%
        $checkDiscountResult = CustomerGroup::checkValidDiscountValue($discount);
        if (!$checkDiscountResult) {
            $validate->message = "Discount percentage should not be more than 100% or less than 0!";
            return $validate;
        }

    }

    /**===================
     *  Helper Functions
     *====================*/
    
     /**
     * Check correct data type of quantity, name and discount.
     * @param String $name 
     * @param String $discount 
     */
     protected static function checkValidQPC($name, $discount){
        if( !(is_string($name) && is_numeric($discount))){
            return false;
        }
        return true;
    }

     /**
     * Check validation discount
     * @param String $discountValue 
     */
     protected static function checkValidDiscountValue($discountValue){
        if($discountValue > 100 || $discountValue < 0){
            return false;
        }
        return true;
    }

    /**
     * Check customer id exsit
     * @param String $cusId 
     */
    protected static function checkCustomerIdExist($cusIds){
       foreach($cusIds as $cusId){
            if(Customer::where('customer_id', $cusId)->exists()){
                return true;
            }
            return false;
        }
    }

    /**
     * Get all customer group record form db
     * @return ResponObject [ data: result_data, messange:result_messange ]
     */
    protected static function getCustomerGroups(){
       $respond = (object)[];

       try{
           $customerGroups = CustomerGroup::all();
           $respond->data = $customerGroups;
           $respond->messange = 'Customer group records found';
       }catch(Exception $e) {
            $respond->data = false;
           $respond->messange = 'Problem while trying to get customers group, table missing or migration!';
        }
        return $respond;
    }

    /**
     * Get customer group record form db base on given id of cus group
     * @return ResponObject [ data: result_data, messange:result_messange ]
     * @param int $id
     */
    protected static function getCustomerGroup($id){
       $respond = (object)[];

       try{
           $customerGroup = CustomerGroup::findOrFail($id);
           $respond->data = $customerGroup;
           $respond->messange = 'Customer group record found';
       }catch(ModelNotFoundException $e) {
            $respond->data = false;
           $respond->messange = 'Customer group record not found!';
        }
        return $respond;
    }

     /**
     * Get all customer record form db
     * @return ResponObject [ data: result_data, messange:result_messange ]
     */
    protected static function getCustomers(){
        $respond = (object)[];
 
        try{
            $customers = Customer::all();
            $respond->data = $customers;
            $respond->messange = 'Customer records found';
        }catch(Exception $e) {
             $respond->data = false;
            $respond->messange = 'Problem while trying to get customer, table missing or migration!';
         }
         return $respond;
     }
 
     /**===============
     *  Relationships
     *=================*/
    
    /**
     * Many relationship with customer
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'customer_group_id');
    }
}
