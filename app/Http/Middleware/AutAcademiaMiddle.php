<?php

namespace App\Http\Middleware;

// use App\Models\Administrador;
use App\Models\Aluno;
use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;

class AutAcademiaMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $tipoUser)
    {

        $email = session('email');

        if ($email) {

            $usuario = Usuario::where('email', $email)->first();

            if (!$usuario) {
                return redirect()->route('login')->withErrors(['email' => 'Não autenticado']);
            }

            $tipoUsuario = $usuario->tipo_usuario;

            if ($tipoUsuario) {
                $tipo = null;


                if ($tipoUsuario instanceof Aluno) {

                    $tipo = 'Aluno';
                    
                // }elseif ($tipoUsuario instanceof Funcionario){

                //     //  dd($tipoUsuario);
                //     $tipo = $tipoUsuario->tipoAdministrador;

                // }
            }

            if ($tipo == $tipoUser) {

                return $next($request);
            } else {
                return back()->withErrors(['email' => 'Acesso não permitido ao perfil']);
            }
         }
      }
   } 
} 
