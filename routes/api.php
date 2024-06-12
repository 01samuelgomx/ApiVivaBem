<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstrutorController;
use App\Http\Controllers\AlunoController;
use App\Models\Funcionario;
use App\Models\Instrutors;

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

//--------------------------------------------------------------------------
// Routes info Matricula e PLano
//--------------------------------------------------------------------------

Route::middleware(['auth:sanctum' , 'aluno'])->group(function () {
    Route::apiResource('aluno', AlunoController::class);

    Route::get('/aluno/{id}/matricula', [AlunoController::class,'getMatricula']);
    Route::get('/aluno/{id}/plano', [AlunoController::class,'getPlano']);
    Route::get('/aluno/{id}/aula', [AlunoController::class,'getAula']);
});
//--------------------------------------------------------------------------
// Routes 
//--------------------------------------------------------------------------
    Route::apiResource('funcionario', Funcionario::class);