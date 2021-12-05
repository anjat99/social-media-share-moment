<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|regex:/^[a-z]{1,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/',
            "password" => [
                'required',
                'min:8', 'max:25',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,25}$/'
            ],
//
        ];
    }

    public function messages(){
        return [
            'required' => 'The :attribute field is required.',
            "email.regex" => "Email is not in valid format",
            "password.regex" => "The :attribute needs to have at least 1 lowercase, 1 uppercase character and 1 digit with minimum 8 and maximum 25 characters.",

        ];
    }
}
