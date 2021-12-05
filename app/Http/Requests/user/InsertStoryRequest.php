<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class InsertStoryRequest extends FormRequest
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
            'title'=>'required|min:2|max:200|regex:/^(.+\s?.*)*$/',
            'description'=>'required|min:2',
            'image'=>'required|file|image|mimes:jpg,jpeg,JPG,JPEG,bmp,png',
        ];
    }

    public function messages()
    {
        return [
            'required'=>'The :attribute field is required.',
            'title.regex' => 'The title of story can contain at least 2 and maximum 255 characters including digits',
            'description.min' => 'The message needs to have at least :min characters!',
            'image.image' => 'Uploaded file must be an image.'
        ];
    }
}
