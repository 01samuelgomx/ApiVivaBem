<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cep', [CepController::class, 'index'])->name('cep');
Route::post('/login', [loginController::class, 'login']);



Route::middleware(['auth:sanctum' , 'aluno'])->group(function () {
    Route::apiResource('aluno', AlunoController::class);

    Route::get('/aluno/{id}/matricula', [AlunoController::class,'getMatricula']);
    Route::get('/aluno/{id}/plano', [AlunoController::class,'getPlano']);
    Route::get('/aluno/{id}/aula', [AlunoController::class,'getAula']);
    
});
