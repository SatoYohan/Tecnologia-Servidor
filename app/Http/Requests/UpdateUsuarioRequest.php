<?php

namespace App\Http\Requests;

class UpdateUsuarioRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('id');

        return [
            'nome_completo' => [
                'sometimes',
                'string',
                'min:3',
                'max:60',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            ],
            'usuario' => [
                'sometimes',
                'string',
                'min:3',
                'max:30',
                'regex:/^[a-z0-9_]+$/',
                'unique:users,usuario,' . $userId,
            ],
            'email' => [
                'sometimes',
                'string',
                'email',
                'min:10',
                'max:35',
                'unique:users,email,' . $userId,
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
            'senha' => [
                'nullable',
                'string',
                'min:8',
                'max:24',
                'regex:/^[a-zA-Z0-9]+$/',
            ],
        ];
    }
}
