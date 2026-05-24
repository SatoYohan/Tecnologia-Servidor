<?php

namespace App\Http\Requests;

class StoreUsuarioRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome_completo' => [
                'required',
                'string',
                'min:3',
                'max:60',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            ],
            'usuario' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[a-z0-9_]+$/',
                'unique:users,usuario',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'min:10',
                'max:35',
                'unique:users,email',
            ],
            'senha' => [
                'required',
                'string',
                'min:8',
                'max:24',
                'regex:/^[a-zA-Z0-9]+$/',
            ],
            'biografia' => [
                'nullable',
                'string',
                'max:150',
            ],
            'foto' => [
                'nullable',
                'string',
            ],
        ];
    }
}
