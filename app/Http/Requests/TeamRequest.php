<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
            'team_name.required' => 'Team name is required.',
            'event_id.required' => 'Please select an event.',
            'team_image.mimes' => 'This image type is not allowed.',
            'team_image.max' => 'The image is too big.',
           
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
            'team_name' => 'required',
            'event_id' => 'required',
            'team_image' => 'mimes:jpg,png,svg|max:20480',
         ];
    }
}
