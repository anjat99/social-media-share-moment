<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class InsertLocationRequest extends FormRequest
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
            'locationName'=>'bail|required|min:2|max:100|unique:locations,name|regex:/^(.+\s?.*)*$/'
        ];
    }

    public function messages()
    {
        return [
            'required'=>'The :attribute field is required.',
            'locationName.regex' => 'The name of location can containt at least 2 and maximum 100 characters including digits'
        ];
    }
}
