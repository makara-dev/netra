<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdjustmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            "datetime"         => "required|string",
            "reference_no"     => "required|string",
            "warehouse"        => "required|string",
            "document"         => "mimes:doc,docx,pdf,txt|max:2048",
            "quantity"         => "required",
            "productvariantid" => "required",
            "types"             => "required",
            "note"             => "",

        ];
    }

    /**
     * Message for fail validation.
     * 
     * @return array
     */
    public function messages(){
        return [
            // date
            "datetime.required" => "Date is required to create adjustment!",
            "datetime.string"   => "Date value should number only!",

            // reference no
            "reference_no.required" => "Reference no is required to adjustment!",
            "reference_no.string"   => "Reference no value should be string!",

            // warehouse
            "warehouse.required" => "Warehouse is required to adjustment!",
            "warehouse.string"   => "Warehouse value should be string!",

            // document
            "document.mimes"   => "Document value should be doc,docx,pdf,txt!",

            // quantity
            "quantity.required" => "Quantity is required to adjustment!",
            // "quantity.string"   => "Quantity value should be number!",

            // productvaraint
            "productvariantid.required" => "Product varaint is required to adjustment!",
            // "productvaraint.string"   => "Product value should be number!",

            // type
            "types.required" => "Type is required to adjustment!",
            // "type.string"   => "Type value should be string!",
            
        ];
    }

}
