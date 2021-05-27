<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'mobile'=>'required|unique:users,mobile|min:11|max:11',
            'password'=>'required|min:8'
        ];
    }
}
