<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class InsertAlbumRequest extends FormRequest
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
            'title'=>'bail|required|min:2|max:100|unique:albums,title|regex:/^(.+\s?.*)*$/',
            'description'=>'bail|required|min:2|max:500'
        ];
    }

    public function messages()
    {
        return [
            'required'=>'The :attribute field is required.',
            'title.regex' => 'The title of album can contains at least 2 and maximum 100 characters including digits'
        ];
    }
}
