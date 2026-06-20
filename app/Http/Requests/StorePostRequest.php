<?php

namespace App\Http\Requests;

class StorePostRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'imagem' => [
                'required',
                'string',
            ],
            'legenda' => [
                'required',
                'string',
                'max:200',
                'regex:/^[a-zA-Z0-9\s]*$/', // RNF06: letras, números e espaços, sem acentos/especiais
            ],
        ];
    }

    /**
     * Validação adicional: verificar tamanho da imagem decodificada (max 10MB - RNF07)
     * e formato (JPG, JPEG, PNG - RNF07)
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('imagem') && $this->imagem) {
                $imagemBase64 = $this->imagem;
                
                // Remover header do Base64 se existir (ex: data:image/jpeg;base64,)
                if (preg_match('/^data:image\/(\w+);base64,/', $imagemBase64, $matches)) {
                    $formato = strtolower($matches[1]);
                    $imagemBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $imagemBase64);
                    
                    // Verificar formato (RNF07)
                    $formatosPermitidos = ['jpg', 'jpeg', 'png'];
                    if (!in_array($formato, $formatosPermitidos)) {
                        $validator->errors()->add('imagem', 'O formato da imagem deve ser JPG, JPEG ou PNG.');
                    }
                }
                
                // Verificar tamanho decodificado (max 10MB - RNF07)
                $decoded = base64_decode($imagemBase64, true);
                if ($decoded === false) {
                    $validator->errors()->add('imagem', 'A imagem deve ser uma string Base64 válida.');
                } elseif (strlen($decoded) > 10 * 1024 * 1024) {
                    $validator->errors()->add('imagem', 'A imagem não pode exceder 10MB.');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'imagem.required' => 'A imagem é obrigatória.',
            'legenda.required' => 'A legenda é obrigatória.',
            'legenda.max' => 'A legenda deve ter no máximo 200 caracteres.',
            'legenda.regex' => 'A legenda deve conter apenas letras, números e espaços (sem acentos ou caracteres especiais).',
        ];
    }
}
