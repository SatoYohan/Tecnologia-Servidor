<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;

// Função para registrar todas as rotas de usuários
$registrarRotasUsuarios = function () {
    Route::prefix('usuarios')->group(function () {
        // Rotas públicas
        Route::post('/', [UsuarioController::class, 'store']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

        // Rotas protegidas por JWT
        Route::middleware('auth:api')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            
            Route::get('/', [UsuarioController::class, 'index']);
            Route::get('/{id}', [UsuarioController::class, 'show']);
            Route::patch('/{id}', [UsuarioController::class, 'update']);
            Route::delete('/{id}', [UsuarioController::class, 'destroy']);
        });
    });
};

// Registra as rotas sem o prefixo "/api" (ex: /usuarios/login)
$registrarRotasUsuarios();

// Registra as rotas COM o prefixo "/api" (ex: /api/usuarios/login)
Route::prefix('api')->group($registrarRotasUsuarios);
