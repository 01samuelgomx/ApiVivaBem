<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class loginController extends Controller
{

    public function login (Request $request){

        
            $credentials = $request->validate([

            'email' => 'required|email',
            'senha' => 'required',

            ]);

                    $usuario = Usuario::where('email', $credentials['email'])->where('senha', $credentials['senha'])->first();

                    // dd($usuario);

                    if($usuario && $usuario->tipo_usuario_type === 'Aluno'){

                        $aluno = $usuario->tipo_usuario_type()->first();
                        if($aluno){

                        $token = $usuario->createToken('Token de acesso')->plainTextToken;

                            return response()->json([

                                'message' => 'login bem sucesso',
                                'usuario' => [

                                    'id' => $usuario->idUsuario,
                                    'nome' => $usuario->nome,
                                    'email' => $usuario->nome,
                                    'tipo_usuario' => $usuario->tipo_usuario_type,

                                    'dados_aluno' => [
                                        'idAluno' =>$aluno->idAluno,
                                        'nome' =>$aluno->nome,
                                    ],
                                 ],
                                 
                                 'acess_token' => $token,
                                 'token_type' => 'Bearer',
                                 
                                ]);
                            }
                        }

            return response()->json(['message' => 'Credenciais invalidas ou usuario nãó é um aluno'], 401);

    }

}