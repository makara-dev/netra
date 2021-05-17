<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationRequest extends FormRequest
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
            'datetime' => 'required|string',
            'reference_num' => 'required|string',
            'status' => 'required|string',
            'total' => 'required|numeric',
            'quotation_note' => 'required|string',
            'staff_note' => 'required|string',
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
            // datetime
            'datetime.required' => 'Datetime is required',
            'datetime.string' => 'Datetime is required as string',

            // reference number
            'reference_num.required' => 'Reference number is required',
            'reference_num.string' => 'Reference number is required as string',

            // status
            'status.required' => 'Status is required',
            'status.string' => 'Status is required as string',


            // total
            'total.required' => 'Total is required',
            'total.decimal' => 'Total is required as decimal',

            // quotation note
            'quotation_note.required' => 'Quotation note is required',
            'quotation_note.string' => 'Quotation note is required as string',

            // staff note
            'staff_note.required' => 'Staff note is required',
            'staff_note.string' => 'Staff note is required as string',
        ];
    }
}
