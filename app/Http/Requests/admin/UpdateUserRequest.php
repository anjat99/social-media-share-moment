<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            "firstName" => "alpha|min:2|max:20|regex:/^[A-ZČĆŽŠĐ][a-zčćžšđ]{1,20}(\s[A-ZČĆŽŠĐ][a-zčćžšđ]{1,20})*$/",
            "lastName" => "alpha|min:2|max:30|regex:/^[A-ZČĆŽŠĐ][a-zčćžšđ]{1,30}(\s[A-ZČĆŽŠĐ][a-zčćžšđ]{1,30})*$/",
            "username" => "min:4|max:50|regex:/^[\d\w\_\-\.]{4,50}$/",
            "email" => "regex:/^[a-z]{1,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/",
        ];
    }

    public function messages(){
        return [
            "email.regex" => "Email is not in valid format",
            "firstname.regex" => "Firstname must contain at least 2 characters and max 20 characters .",
            "lastname.regex" => "Firstname must contain at least 2 characters and max 30 characters .",
            "username.unique" => "Username already exists.",
            "username.regex" => "Username can contain only digits, letters and signs '-' or '_' and must have at least 4 characters and max 50 characters",
        ];
    }
}
