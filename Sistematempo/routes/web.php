<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/cidades', [\App\Http\Controllers\CidadeController::class, 'index'])->name('Cidade');
Route::get('/cidades/create', [\App\Http\Controllers\CidadeController::class, 'create'])->name('cidade.create');
Route::post('/cidades', [\App\Http\Controllers\CidadeController::class, 'store'])->name('cidade.store');