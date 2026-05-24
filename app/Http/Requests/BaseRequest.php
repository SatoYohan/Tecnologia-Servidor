<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{
    use ApiResponse;

    protected function failedValidation(Validator $validator)
    {
        $erros = $validator->errors()->toArray();

        throw new HttpResponseException(
            $this->erro('DADOS_INCOMPLETOS', 'Dados inválidos ou incompletos', $erros, 400)
        );
    }
}
