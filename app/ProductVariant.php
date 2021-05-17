<?php

namespace App;

use Exception;
use App\Quotation;
use App\Adjustment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    //
    protected $table = 'product_variants';

    //
    protected $primaryKey = 'product_variant_id';

    //
    protected $fillable = [
        'product_variant_sku', 'cost', 'price', 'quantity'
    ];

    public $timestamps = true;

    //custom field
    protected $appends = [
        'rowId'
    ];


    //getter and setter
    public function setRowIdAttribute($rowId) //set rowId
    { 
        return $this->rowId = $rowId;
    }
    public function getRowIdAttribute($rowId) //get rowId
    { 
        return $this->rowId = $rowId;
    }

    /**===================
     *  Helper Functions
     *====================*/

     /**
     * Get all product variant record form db
     * @return ResponObject [ data: result_data, messange:result_messange ]
     */
    protected static function getProductVariants(){
        $respond = (object)[];
 
        try{
            $productVariants = ProductVariant::orderBy('product_variant_id', 'DESC')->get();
            $respond->data = $productVariants;
            $respond->messange = 'Product variants found';
        }catch(Exception $e) {
             $respond->data = false;
            $respond->messange = 'Problem while trying to get product variants table missing or migration!';
         }
         return $respond;
     }

     /**
     * Find product variant record form db
     * @return ResponObject [ data: result_data, messange:result_messange ]
     */
    protected static function getProductVariant($id){
        $respond = (object)[];
 
        try{
            $productVariant = ProductVariant::findOrFail($id);
            $respond->data = $productVariant;
            $respond->messange = 'Product variant found';
        }catch(ModelNotFoundException $e) {
             $respond->data = false;
            $respond->messange = 'Product variant not found!';
         }
         return $respond;
     }


    //many to one
    public function createdBy()
    {
        return $this->belongsTo(staff::class, 'staff_id', 'created_by');
    }

    //many to one
    public function updatedBy()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'updated_by');
    }

    //many to one
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    //many to one
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_variant_id', 'product_variant_id');
    }

    // many to many
    public function quotations(){
        return $this->belongsToMany(Quotation::class,
                    'quotations_productvars_bridges', 
                    'quotation_id', 
                    'product_variant_id'
                );
    }


    //many to many
    public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'productvariant_attributevalue_bridge',
            'product_variant_id',
            'attribute_value_id'
        );
    }

    // one to one relationship
    public function featuredProduct()
    {
        return $this->hasOne(FeaturedProduct::class, 'product_variant_id', 'product_variant_id');
    }

    /**
     * function to get all order and quotations
     * @return data of product and order
     */
    public function orders()
    {
        return $this->hasMany(
            Quotation::class,
            'orders_product_variants_bridges',
            'product_variant_id',
            'order_id',
        );
    }

    //get table column name
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    //get product variant's attribute_values name as a string
    public function getAttributeValuesName()
    {
        $attributeValueNames = $this->attributeValues()->pluck('attribute_value');
        return $attributeValueNames->reduce(function ($carry, $item) {
            return $carry .' '. $item;
        });
    }

    // many to many (new update)
    public function giftsets(){
        return $this->belongsToMany(
            Giftset::class,
            'productvar_giftset_bridges',
            'product_variant_id',
            'giftset_id'
        );
    }

    // many to many
    public function promosetsPurchase(){
        return $this->belongsToMany(
            Promoset::class,
            'pvpurchase_promoset_bridges',
            'product_variant_id',
            'promoset_id'
        );
    }

    // many to many (dynamic function)
    public function promosetsFree(){
        return $this->belongsToMany(
            Promoset::class,
            'pvfree_promoset_bridges',
            'product_variant_id',
            'promoset_id'
        );
    }

    /**
     * Many relationship with adjustment
     */
    public function adjustments()
    {
        return $this->belongsToMany(
            Adjustment::class, 
            'product_variant_adjustments',
            'product_variant_id',
            'adjustment_id'
        )
        ->withPivot('quantity', 'type');
    }

}
