<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            "name"      => "required|string|regex:/^[\pL\s\-]+$/u",
            "phone"     => "required|numeric",
            "address"   => "required|string",
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
            "name.string"   => "Customer name value should be letter only!",

            // phone
            "phone.required" => "Customer phone is required to create customer!",
            "phone.string"   => "Customer phone value should be number!",

            // address
            "address.required" => "Customer address is required to create customer!",
            "address.string"   => "Customer address value should be number!",
            
        ];
    }
}
