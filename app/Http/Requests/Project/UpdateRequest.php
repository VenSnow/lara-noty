<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:150',
            'domain' => 'required|min:3|max:150',
            'client_id' => 'required|numeric',
            'domain_end' => 'required|date',
            'host_id' => 'required|numeric',
            'host_end' => 'required|date',
            'ftp_login' => 'required|min:2',
            'ftp_password' => 'required',
            'db_login' => 'required|min:2',
            'db_password' => 'required',
            'comment' => 'sometimes|max:500',
        ];
    }
}
