<?php

namespace App;
use App\ProductVariant;
use Exception;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    /**
     * Table name.
     * @var String
     */
    protected $table = 'adjustments';

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
        'datetime',
        'reference_no',
        'warehouse',
        'document',
        'created_by',
        'note',

    ];

    /**
     * Get all customer group from database
     * @return ResponObject [ data: result_data, messange:result_messange ]
     * @param String $name
     * @param Int $discount
     * @param Int $customer_id
     */
    protected static function checkValidateRequest(
        $reference_no,
        $warehouse,
        $quantity,
        $document,
        $type,
        $note
    ) {
        $validate = (object)[];

        // validate quantity is a string and quantity is a number
        $isNumeric = Adjustment::checkValidQPC($warehouse, $quantity);
        if (!$isNumeric) {
            $validate->message = "Quantity should be number and Name of Warehouse should be string!";
            return $validate;
        }


    }

    /**===================
     *  Helper Functions
     *====================*/

      /**
     * Check correct data type of quantity, warehouse and quantity.
     * @param Int $quantity 
     * @param String $warehouse 
     */
    protected static function checkValidQPC($warehouse, $quantity){
        if( !(is_string($warehouse) && is_numeric($quantity))){
            return false;
        }
        return true;
    }

    /**
     * Get all adjustment record form db
     * @return ResponObject [ data: result_data, messange:result_messange ]
     */
    protected static function getAdjustments(){
        $respond = (object)[];
 
        try{
            $adjustments = Adjustment::orderBy('id', 'DESC')->get();
            $respond->data = $adjustments;
            $respond->messange = 'Adjustments records found';
        }catch(Exception $e) {
             $respond->data = false;
            $respond->messange = 'Problem while trying to get adjustments, table missing or migration!';
         }
         return $respond;
     }
 

     /**
     * Get adjustment record form db base on given id
     * @return ResponObject [ data: result_data, messange:result_messange ]
     * @param int $id
     */
    protected static function getAdjustment($id){
        $respond = (object)[];
 
        try{
            $adjustment = Adjustment::findOrFail($id);
            $respond->data = $adjustment;
            $respond->messange = 'Ajustment record found';
        }catch(ModelNotFoundException $e) {
             $respond->data = false;
            $respond->messange = 'Adjustment record not found!';
         }
         return $respond;
     }

      /**
     * Get the user create adjustment
     * @return $result return the name of user are created adjustment
     */
    protected static function getCreatedBy($user_name){
        if(Auth::user()->staff->is_admin == 1){
            $result =  $user_name." (Admin)";
        }elseif(Auth::user()->staff->is_admin == 0){
            $result =  $user_name." (Staff)";
        }
        return $result;
     }

      /**
     * upload ducument
     * @return $filename return the name of file
     */
    protected static function uploadDocument($files){
       if ($files) {
            $destinationPath = 'file/'; // upload path
            $filename = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $filename);
        }else {
            $filename = null;
        }
        return $filename;
     }


    /**===============
     *  Relationships
     *=================*/
    
    /**
     * Many relationship with product variants
     */
    public function product_variants()
    {
        return $this->belongsToMany(
            ProductVariant::class, 
            'product_variant_adjustments',
            'adjustment_id',
            'product_variant_id'
        )
        ->withPivot('quantity', 'type');
    }
}
