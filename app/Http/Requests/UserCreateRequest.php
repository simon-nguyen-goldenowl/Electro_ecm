<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'address' => 'required',
            'phone' => 'required|regex:/(01)[0-9]{6}/'
        ];
    }
    public function messages()
    {
        return [
            'phone.regex' => 'phone number have to starts with 01 and is followed by 6 numbers'
        ];
    }
}
