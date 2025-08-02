<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TradeRequest extends FormRequest
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

            'trade_date.required' => 'Please select a date.',
            'reward.required' => 'Interest is required.',
            'user_id.required' => 'Please select a client.',

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
            'trade_date' => 'required',
            'reward' => 'required',
            'user_id' => 'required',

        ];
    }
}
