<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
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
            'title'=>'min:2|max:100|regex:/^(.+\s?.*)*$/',
            'description'=>'min:2|max:500',
        ];
    }

    public function messages()
    {
        return [
            'title.regex' => 'The name of room service can contain at least 2 and maximum 100 characters including digits'
        ];
    }
}
