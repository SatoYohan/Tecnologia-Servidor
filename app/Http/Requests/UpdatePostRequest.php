<?php

namespace App\Http\Requests;

class UpdatePostRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'legenda' => [
                'required',
                'string',
                'max:200',
                'regex:/^[a-zA-Z0-9\s]*$/', // RNF06/RNF08: letras, números e espaços, sem acentos/especiais
            ],
        ];
    }

    public function messages()
    {
        return [
            'legenda.required' => 'A legenda é obrigatória.',
            'legenda.max' => 'A legenda deve ter no máximo 200 caracteres.',
            'legenda.regex' => 'A legenda deve conter apenas letras, números e espaços (sem acentos ou caracteres especiais).',
        ];
    }
}
