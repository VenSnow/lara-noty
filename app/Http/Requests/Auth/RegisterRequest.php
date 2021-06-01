<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        return [
            'name' => 'required|min:3|max:25|unique:users|without_spaces|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'email' => 'required|email|min:3|max:25|unique:users',
            'password' => 'required|min:4|confirmed',
        ];
    }
}
