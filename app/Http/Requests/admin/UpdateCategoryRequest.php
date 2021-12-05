<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'categoryName'=>'min:2|max:100|regex:/^(.+\s?.*)*$/',
            'description'=>'min:2|max:500'
        ];
    }

    public function messages()
    {
        return [
            'categoryName.regex' => 'The name of category can containt at least 2 and maximum 100 characters including digits'
        ];
    }
}
