<?php

use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::apiResource('marca', MarcaController::class);
Route::apiResource('produto', ProdutoController::class);
Route::get('/marcas/create', [MarcaController::class, 'create'])->name('marca.create');

