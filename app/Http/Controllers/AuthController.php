<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        $credentials = [
            'usuario' => $request->usuario,
            'password' => $request->senha
        ];

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->erro('CREDENCIAIS_INVALIDAS', 'Credenciais inválidas', [], 401);
        }

        $user = Auth::guard('api')->user();

        return $this->sucesso('LOGIN_SUCESSO', 'Login realizado com sucesso', [
            'token' => $token,
            'usuario' => [
                'id' => (string) $user->id,
                'nome' => $user->nome_completo,
                'email' => $user->email,
                'usuario' => $user->usuario,
                'is_admin' => $user->is_admin,
            ]
        ], 200);
    }

    public function refreshToken(Request $request)
    {
        $request->validate(['refreshToken' => 'required|string']);

        try {
            $newToken = Auth::guard('api')->setToken($request->refreshToken)->refresh();
            
            return $this->sucesso('TOKEN_RENOVADO', 'Token renovado com sucesso', [
                'token' => $newToken
            ], 200);
        } catch (\Exception $e) {
            return $this->erro('TOKEN_INVALIDO', 'Refresh token inválido ou expirado', [], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('api')->invalidate(true);
            return $this->sucesso('LOGOUT_SUCESSO', 'Logout realizado com sucesso', [], 200);
        } catch (\Exception $e) {
            return $this->erro('TOKEN_INVALIDO', 'Token inválido ou não informado', [], 400);
        }
    }
}
