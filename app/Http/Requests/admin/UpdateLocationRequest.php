<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
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
            'locationName'=>'min:2|max:100|regex:/^(.+\s?.*)*$/'
        ];
    }

    public function messages()
    {
        return [
            'locationName.regex' => 'The name of location can containt at least 2 and maximum 100 characters including digits'
        ];
    }
}
