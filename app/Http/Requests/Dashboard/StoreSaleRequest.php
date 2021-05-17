<?php

namespace App\Http\Requests\Dashboard;

use DateTime;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'datetime' => 'required|date',
            'reference-num' => 'required|string',
            'sale-status' => 'required|string',
            'payment-status' => 'required|string',
            'total' => 'required|numeric',
            'paid' => 'required|numeric',
            'sale-note' => 'required|string',
            'staff-note' => 'required|string',
            'customer_id' => 'required|numeric',
        ];
    }

    /**
     * Message fail validation 
     */

     public function messages()
     {
         return [
            // datetime
            'datetime.required' => 'Sale datetime is required to create sale!',
            'datetime.date' => 'Sale datetime value should be string!',
            // reference num
            'reference-num.required' => 'Sale reference is required to create sale!',
            'reference-num.string' => 'Sale reference-nume value should be string!',
            // sale status
            'sale-status.required' => 'Sale sale-note is required to create sale!',
            'sale-status.string' => 'Sale sale-status value should be string!',
            // payment status
            'payment-status.required' => 'Sale payment-status is required to create sale!',
            'payment-status.string' => 'Sale payment-note value should be string!',
            // total 
            'total.required' => 'Sale total is required to create sale!',
            'total.string' => 'Sale total value should be number!',
            // paid
            'paid.required' => 'Sale paid is required to create sale!',
            'paid.string' => 'Sale paid value should be number!',
            // sale note
            'sale-note.required' => 'Sale sale-note is required to create sale!',
            'sale-note.string' => 'Sale sale-note value should be string!',
            // staff note
            'staff-note.required' => 'Sale staff-note is required to create sale!',
            'staff-note.string' => 'Sale staff-note value should be string!',
            // customer id
            'customer_id.required' => 'Sale customer id is required to create sale!',
            'customer_id.string' => 'Sale customer id value should be number!',
        
         ];
     }
}
