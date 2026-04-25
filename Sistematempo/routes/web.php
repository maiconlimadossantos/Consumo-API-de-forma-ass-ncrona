<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/cidades', [\App\Http\Controllers\CidadeController::class, 'index'])->name('cidade.index');