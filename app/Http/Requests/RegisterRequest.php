<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "firstname" => "bail|required|alpha|min:2|max:30|regex:/^[A-ZČĆŽŠĐ][a-zčćžšđ]{1,20}(\s[A-ZČĆŽŠĐ][a-zčćžšđ]{1,20})*$/",
            "lastname" => "bail|required|alpha|min:2|max:50|regex:/^[A-ZČĆŽŠĐ][a-zčćžšđ]{1,30}(\s[A-ZČĆŽŠĐ][a-zčćžšđ]{1,30})*$/",
            "username" => "bail|required|min:4|max:50|unique:users|regex:/^[\d\w\_\-\.]{4,50}$/",
            "email" => "bail|required|unique:users|regex:/^[a-z]{1,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/",
            "password" => [
                'required',
                'min:8', 'max:25',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,25}$/'
            ],
            'password_confirmation' => "required|min:8|max:25|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,25}$/",
            "birthdate" => "bail|required|date",
            "gender" => "required"
        ];
    }

    public function messages(){
        return [
            'required' => 'The :attribute field is required.',
            "firstname.regex" => "Firstname must contain at least 2 characters and max 20 characters .",
            "lastname.regex" => "Firstname must contain at least 2 characters and max 30 characters .",

            "username.unique" => "Username already exists.",
            "username.regex" => "Username can contain only digits, letters and signs '-' or '_' and must have at least 4 characters and max 50 characters",

            "email.unique" => "Email already exists.",
            "email.regex" => "Email is not in valid format (example: pera.peric@gmail.com)",
            "password.regex" => "The :attribute needs to have at least 1 lowercase, 1 uppercase character and 1 digit with minimum 8 and maximum 25 characters.",
            "password_confirmation.regex" => "The :attribute needs to have at least 1 lowercase, 1 uppercase character and 1 digit with minimum 8 and maximum 25 characters.",
            "birthdate" => "Incorrect date format."
        ];
    }
}
