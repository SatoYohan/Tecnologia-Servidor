<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Retorna uma resposta de sucesso.
     *
     * @param string $codigo
     * @param string $mensagem
     * @param mixed $dados
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sucesso(string $codigo, string $mensagem, $dados = [], int $statusCode = 200)
    {
        return response()->json([
            'status' => 'sucesso',
            'codigo' => $codigo,
            'mensagem' => $mensagem,
            'dados' => $dados,
        ], $statusCode);
    }

    /**
     * Retorna uma resposta de erro.
     *
     * @param string $codigo
     * @param string $mensagem
     * @param mixed $dados
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function erro(string $codigo, string $mensagem, $dados = [], int $statusCode = 400)
    {
        return response()->json([
            'status' => 'erro',
            'codigo' => $codigo,
            'mensagem' => $mensagem,
            'dados' => (object) $dados,
        ], $statusCode);
    }
}
