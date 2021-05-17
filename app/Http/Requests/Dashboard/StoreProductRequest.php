<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'      => 'required|string',
            'sku'       => 'required|string',
            'quantity'  => 'required|numeric',
            'price'     => 'required|numeric',
            'cost'      => 'required|numeric',
            
        ];
    }

    /**
     * Message for fail validation.
     * 
     * @return array
     */
    public function messages(){
        return [
            // name
            'name.required' => 'Product name is required to create product!',
            'name.string'   => 'Product name value should be string!',

            // sku
            'sku.required' => 'Product SKU is required to create product!',
            'sku.string'   => 'Product SKU value should be string!',

            // quantity
            'quantity.required' => 'Product quantity is required to create product!',
            'quantity.string'   => 'Product quantity value should be number!',

            // price
            'price.required' => 'Product price is required to create product!',
            'price.string'   => 'Product price value should be string!',

            // cost
            'cost.required' => 'Product cost is required to create product!',
            'cost.string'   => 'Product cost value should be string!',
            
        ];
    }

}
