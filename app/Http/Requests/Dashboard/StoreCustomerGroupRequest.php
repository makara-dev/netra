<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerGroupRequest extends FormRequest
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
            "name"      => "required|regex:/(^[A-Za-z0-9 ]+$)+/",
            "discount"  => "required|numeric",
            
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
            "name.required" => "Customer name is required to create customer!",
            "name.regex"   => "Customer name value should be letter and number only!",

            // discount
            "discount.required" => "Customer discount is required to create customer!",
            "discount.numeric"   => "Customer discount value should be number only!",
            
        ];
    }

}
