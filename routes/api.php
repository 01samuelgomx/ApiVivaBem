<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstrutorController;
use App\Http\Controllers\AlunoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('aluno', 'App\Http\Controllers\AlunoController');
Route::apiResource('instrutor', 'App\Http\Controllers\instrutorController');

//Routes info Matricula e PLano
Route::prefix('aluno')->group(function(){
Route::get('/{id}/matricula',[AlunoController::class, 'getMatricula']);
Route::get('/{id}/plano',[AlunoController::class, 'getPlano']);
});
