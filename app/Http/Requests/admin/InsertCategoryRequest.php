<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class InsertCategoryRequest extends FormRequest
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
            'categoryName'=>'bail|required|min:2|max:100|unique:categories,name|regex:/^(.+\s?.*)*$/',
            'description'=>'bail|required|min:2|max:500'
        ];
    }

    public function messages()
    {
        return [
            'required'=>'The :attribute field is required.',
            'categoryName.regex' => 'The name of category can containt at least 2 and maximum 100 characters including digits'
        ];
    }
}
