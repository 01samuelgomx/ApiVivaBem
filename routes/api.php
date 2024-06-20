<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\loginController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::apiResource('funcionario', Funcionario::class);

Route::apiResource('Funcionario', 'App/Http/Controllers/FuncionarioController.php');

//--------------------------------------------------------------------------
// Routes info Matricula e PLano
//--------------------------------------------------------------------------

Route::post('/login', [loginController::class, 'login']);

Route::middleware(['auth:sanctum' , 'aluno'])->group(function () {
    Route::apiResource('aluno', AlunoController::class);
    Route::get('/aluno/{id}/matricula', [AlunoController::class,'getMatricula']);
    Route::get('/aluno/{id}/plano', [AlunoController::class,'getPlano']);
    Route::get('/aluno/{id}/aula', [AlunoController::class,'getAula']);
    
});