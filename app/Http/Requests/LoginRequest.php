<?php

namespace App\Http\Requests;

class LoginRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'usuario' => [
                'required',
                'string',
            ],
            'senha' => [
                'required',
                'string',
            ],
        ];
    }
}
