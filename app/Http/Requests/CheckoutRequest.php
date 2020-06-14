<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'sponsor_id'=> '',
            'user_id'=> 'required',
            'email'=> 'required',
            'phone'=> 'required',
            'name'=> 'required|alpha_dash|unique:users',
            'city'=> 'required',
            'password'=> 'required|confirmed|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'sponsor_id'=> 'Sponsor ID',
            'user_id'=> 'User ID',
            'email'=> 'Email',
            'phone'=> 'Phone',
            'name'=> 'Username',
            'city'=> 'City',
            'password'=> 'Password',
        ];
    }
}
