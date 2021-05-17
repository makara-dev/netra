<?php

namespace App;

use App\CustomLibs\ArrayCompare;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use ArrayCompare;
    
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name', 'description', 'thumbnail'
    ];

    public $timestamps = true;

    //one to many relationship
    public function images() {
        return $this->hasMany(Image::class, 'product_id', 'product_id');
    }

    //one to many relationship
    public function productVariants() {
        return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
    }

    //many to one relationship
    public function Category() {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // one to many
    public function reviews() {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }


    //get table column name
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    /**
     * get Products from a set amount of days
     * @param int $days 
     * @return Collection|Product[]
     */
    public function newArrival(int $days) {
        if ($days > 0) {
            $pastWeek =  Carbon::now()->subDays($days);

            $sortedProducts = Product::where('created_at', '>', $pastWeek)
                ->orderBy('created_at', 'desc');
            return $sortedProducts;
        } else {
            throw new ErrorException('Invalid Passed Parameter');
        }
    }

    /**
     * get Color
     * @return attributeValue - $color
     */
    public function getColor() {
        //first product variant
        try {
            $productVariant = $this->productVariants[0];
        } catch (Exception $e) {
            return null;
        }

        //attribute values
        $attributeValues = $productVariant->attributeValues;

        //get color 
        $color = null;

        foreach ($attributeValues as $attributeValue) {
            $attributeName = $attributeValue->attribute->attribute_name; //get attribute name of the attribute value
            if ($attributeName === 'color') {
                $color = $attributeValue;
            }
        }

        return $color;
    }

    /**
     * get  Attributes of the Product Include ALL of its related child record
     * @return Collection|Attribute[]
     */
    public function selectAllAttributes() {
        //get attribute_values linked to product_variants
        $attributes = new EloquentCollection();
        foreach ($this->productVariants as $pv) {
            foreach ($pv->attributeValues as $attrVal) {
                $attribute = $attrVal->attribute;
                if ($attributes->where('attribute_id', $attribute->attribute_id)->count() == 0) { //add non-duplicates into attributes collection
                    $attributes->add($attribute);       //add to a collection
                }
            }
        }
        return $attributes;
    }

    /**
     * get a CLONE of Attributes of the Product
     * @return Collection|Attribute[]
     */
    public function selectAttributes()
    { // getAttributes() has duplicate name as laravel MODEL name
        // get product variants
        $productVariants = $this->productVariants()->where('quantity', '>', 0)->get();

        //get attribute_values linked to product_variants
        $attributes = new Collection();
        foreach ($productVariants as $productVariant) {
            foreach ($productVariant->attributeValues as $attributeValue) {
                $tempAttribute = $attributeValue->attribute;
                if ($attributes->where('attribute_id', $tempAttribute->attribute_id)->count() === 0) { //add non-duplicates into attributes collection
                    $attribute = (object) [ //make a new objects model
                        'attribute_id' => $tempAttribute->attribute_id,
                        'attribute_name' => $tempAttribute->attribute_name,
                        'attributeValues' => new Collection(),
                    ];
                    $attributes->add($attribute);  //add to a collection
                } 
                foreach ($attributes as $attribute) {// select child record 
                    if (
                        $attribute->attribute_id === $attributeValue->attribute->attribute_id
                        &&
                        !$attribute->attributeValues->contains(function ($item) use ($attributeValue) {
                            return $item->attribute_value_id === $attributeValue->attribute_value_id;
                        })
                    ) {
                        $attribute->attributeValues->add($attributeValue);

                        //decided to sort disposal date by char length 
                        if($attribute->attribute_name !== 'disposal'){
                            $attribute->attributeValues = $attribute->attributeValues->sortByDesc('attribute_value'); 
                        }else{
                            // To Do : write sort here
                        }
                    }
                }
            }
        }
        return $attributes;
        //unefficient
        //change this later
        // foreach ($productVariants as $productVariant) {
        //     foreach ($productVariant->attributeValues as $attributeValue) {
        //         foreach ($attributes as $attribute) {
        //             if (
        //                 $attribute->attribute_id === $attributeValue->attribute->attribute_id 
        //                 &&
        //                 !$attribute->attributeValues->contains(function($item) use ($attributeValue){
        //                     return $item->attribute_value_id == $attributeValue->attribute_value_id;
        //                 })
        //             ) {
        //                 $attribute->attributeValues->add($attributeValue);
        //             }
        //         }
        //     }
        // }
    }

    /**
     * find a productvariant in product by attribute values
     * @return ProductVariant
     * @return null
     */
    public function findProductVariantByAttrVal($inputs){
        foreach ($this->productVariants as $item) {
            $attributeValues = $item    //get all attribute_value_id from current product_variant
                ->attributeValues
                ->pluck('attribute_value_id')
                ->toArray();
                
            if (ArrayCompare::array_equals($attributeValues, $inputs)) { //compare with inputs attribute_value_id
                return $item;
            }
        }
        return null;
    }

    /**
     * get product thumbnail Image Model 
     * @return App\Image $thumbnail
     */
    public function getThumbnailObject(){
        return $this->images()->where('is_thumbnail', true)->first();
    }

    /**
     * check if the current product has a thumbnail image
     */
    public function hasThumbnail(){
        return !empty($this->getThumbnailObject());
    }

    
}
