<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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

    public function messages()
    {
        return [
            
            'transaction_date.required' => 'Please select a date.',
            'transaction_type.required' => 'Please select an event.',
            'transaction_amount.required' => 'Amount is required.',
            'authorised_by.required' => 'Authorised by is required.',
            
           
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transaction_date' => 'required',
            'transaction_type' => 'required',
            'transaction_amount' => 'required',
            'authorised_by' => 'required',
           
         ];
    }
}
