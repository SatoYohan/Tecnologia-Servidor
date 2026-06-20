<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PostController;

// Função para registrar todas as rotas
$registrarRotas = function () {
    Route::prefix('usuarios')->group(function () {
        // Rotas públicas
        Route::post('/', [UsuarioController::class, 'store']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

        // Rotas protegidas por JWT
        Route::middleware('auth:api')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            
            Route::get('/', [UsuarioController::class, 'index']);
            Route::get('/{id}', [UsuarioController::class, 'show'])->where('id', '[0-9]+');
            Route::patch('/{id}', [UsuarioController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('/{id}', [UsuarioController::class, 'destroy'])->where('id', '[0-9]+');

            // Rotas de Posts (Entrega 3)
            Route::prefix('{id_usuario}/posts')->where(['id_usuario' => '[0-9]+'])->group(function () {
                Route::get('/', [PostController::class, 'index']);
                Route::post('/', [PostController::class, 'store']);
                Route::get('/{id_post}', [PostController::class, 'show'])->where('id_post', '[0-9]+');
                Route::post('/{id_post}', [PostController::class, 'curtir'])->where('id_post', '[0-9]+');
                Route::patch('/{id_post}', [PostController::class, 'update'])->where('id_post', '[0-9]+');
                Route::delete('/{id_post}', [PostController::class, 'destroy'])->where('id_post', '[0-9]+');
            });
        });
    });
};

// Registra as rotas sem o prefixo "/api" (ex: /usuarios/login) — Swagger compliance
$registrarRotas();

// Registra as rotas COM o prefixo "/api" (ex: /api/usuarios/login) — fallback
Route::prefix('api')->group($registrarRotas);
