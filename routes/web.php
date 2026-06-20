<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/cadastro', function () {
    return view('cadastro');
});

Route::get('/feed', function () {
    return view('feed');
});

Route::get('/perfil', function () {
    return view('perfil');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/servidor', [App\Http\Controllers\MonitorController::class, 'index']);
