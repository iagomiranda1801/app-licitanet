<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::apiResource('marca', MarcaController::class);
Route::apiResource('cidade', CidadeController::class);
Route::apiResource('produto', ProdutoController::class);
Route::get('/marcas/create', [MarcaController::class, 'create'])->name('marca.create');
Route::get('/cidade/create', [CidadeController::class, 'create'])->name('cidade.create');
Route::get('/produto/create', [ProdutoController::class, 'create'])->name('produto.create');