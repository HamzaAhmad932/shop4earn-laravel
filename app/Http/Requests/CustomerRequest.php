<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'position'=> 'required',
            'name'=>'required|unique:users',
            'password'=>'required|confirmed|min:6',
            'user_id'=> 'required',
            'city'=> 'required',
            'mobile'=> 'required',
        ];
    }

    public function attributes()
    {
        return [
            'position'=> 'Position',
            'name'=> 'Username',
            'email'=>'Email',
            'password'=>'Password',
            'user_id'=> 'User ID',
            'city'=> 'City',
            'mobile'=> 'Mobile',
        ];
    }
}
