<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'name'=>"bail|required|regex:/^[A-ZČĆŽŠĐ][a-zčćžšđ]{1,40}(\s[A-ZČĆŽŠĐ][a-zčćžšđ]{1,40})*$/|alpha|min:2|max:20",
            "email"=>"bail|required|regex:/^[a-z]{1,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/",
            "subject"=>"bail|required|min:2",
            "message"=>'bail|required|min:2'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'message.min' => 'The message needs to have at least :min characters!',
             "name.regex" => "Name must start with one uppercase letter, contain at least 2 characters and max 40 characters .Also if you have more names you can type it in",
            "email.regex" => "Email is not in valid format ( example: something@gmail.com)",
        ];
    }
}
