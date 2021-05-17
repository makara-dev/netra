<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreExchangeRateRequest extends FormRequest
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
            "currency-code"      => "required|string|min:1|max:20",
            "currency-name"      => "required|string|min:1|max:20",
            "exrate"             => "required|numeric|min:0",
            "symbol"             => "required|string|min:1|max:10",
            
        ];
    }

    /**
     * Message for fail validation.
     * 
     * @return array
     */
    public function messages(){
        return [
           // currency code
           "currency-code.required" => "Currency code is required to create exchange rate!",
           "currency-code.string"   => "Currency code value should be letter only!",

           // currency name
           "currency-name.required" => "Currency name is required to create exchange rate!",
           "currency-name.string"   => "Currency name value should be letter!",

           // exchange rate
           "exrate.required" => "Exchange rate is required to create exchange rate!",
           "exrate.numeric"   => "Exchange rate value should be number!",

           // symbol
           "symbol.required" => "Symbol is required to create exchange rate!",
           "symbol.string"   => "Symbol value should be symbol and letter!",
            
        ];
    }

}
