<?php

namespace App\Http\Requests\Host;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:150',
            'address' => 'required|min:3|max:100',
            'host_login' => 'required|min:3|max:100',
            'host_password' => 'required|min:3|max:100',
            'comment' => 'sometimes|max:500',
        ];
    }
}
