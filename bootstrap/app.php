<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Configuração de CORS para permitir acesso de outros IPs na VLAN
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('usuarios') || $request->is('usuarios/*') || $request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'codigo' => 'ACESSO_NEGADO',
                    'mensagem' => 'Token não fornecido ou expirado/inválido'
                ], 401);
            }
        });
    })->create();
