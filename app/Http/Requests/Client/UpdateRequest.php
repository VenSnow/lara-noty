<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2|max:25',
            'last_name' => 'sometimes|min:2|max:25',
            'email' => 'required|email|min:2|max:50',
            'phone' => 'required|min:7|max:50',
            'comment' => 'sometimes|max:500',
        ];
    }
}
