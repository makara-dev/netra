<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'reference_num' => 'required|string',
            'order_status' => 'required|string',
            'costs' => 'required|numeric',
            'prices' => 'required|numeric',
            'delivery_fee' => 'required|numeric',
            // 'totals' => 'required|numeric',
            'sale_tax' => 'required|numeric',
            // 'sale_type' => 'required|string',
            'payment_status' => 'required|string',
            'delivery_status' => 'required|string',
            'payment_method' => 'required|string',
            'customer_id' => 'required|numeric',
            'exchange_id' => 'required|numeric',
        ];
    }

    /**
     * Message for fail validation.
     * 
     * @return array
     */
    public function messages()
    {
        return [

            // reference number
            'reference_num.required' => 'Reference number is required',
            'reference_num.string' => 'Reference number is required as string',

            // status
            'order_status.required' => 'Status is required',
            'order_status.string' => 'Status is required as string',

            // total cost 
            'costs.required' => 'total cost is required',
            'costs.string' => 'total cost is required as number',

            // total price 
            'prices.required' => 'total price is required',
            'prices.string' => 'total price is required as number',

            // grand total
            // 'totals.required' => 'grand total is required',
            // 'totals.string' => 'grand total is required as number',

            // delivery fee
            'delivery_fee.required' => 'delivery fee is required',
            'delivery_fee.string' => 'delivery fee is required as number',

            // sale tax
            'sale_tax.required' => 'sale tax is required',
            'sale_tax.string' => 'sale tax is required as number',

            // sale type
            // 'sale_type.required' => 'sale type is required',
            // 'sale_type.string' => 'sale type is required as string',

            // paymet status
            'payment_status.required' => 'payment status is required',
            'payment_status.string' => 'payment status is required as string',

            // delivery status
            'delivery_status.required' => 'delivery status is required',
            'delivery_status.string' => 'delivery status is required as string',

            // payment method
            'payment_method.required' => 'payment method is required',
            'payment_method.string' => 'payment method is required as string',

            // order status
            'order_status.required' => 'order status is required',
            'order_status.string' => 'order status is required as string',

            // order status
            'customer_id.required' => 'customer id is required',
            'customer_id.string' => 'customer id is required as string',

            // exchange rate id
            'exchange_id.required' => 'exchange rate id is required',
            'exchange_id.string' => 'exchange rate id is required as string',
        ];
    }
}
