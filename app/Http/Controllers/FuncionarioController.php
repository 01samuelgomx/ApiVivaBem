<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FuncionarioController extends Controller
{
     // variael pública do Funcionario.
     public $funcionarios;

     // Definição do método construtor da classe.
     public function __construct(Funcionario $func)
     {
         $this->funcionarios = $func;
     }
    /**
     * @return \Illuminate\Http\Response
     */
    //------------------------------------------ 

    public function index()
    {
        // return ['Cheguei Aqui index'];

        $funcionarios = $this->funcionarios->all();

        return response()->json($funcionarios, 200);
    }

    //------------------------------------------ 

    public function store(Request $request)
    {
        $request->validate($this->funcionarios->RegrasFunc(), $this->funcionarios->FeedbackFunc());
        $imagem = $request->file('foto');
        $imagem_url = $imagem->store('imagem', 'public');

        //dd($imagem_url);

        $funcionarios = $this->funcionarios->create([
            'nome' => $request->nome,
            'email' => $request->email,
            'foto' => $imagem_url
        ]);

        return response()->json($funcionarios, 200);
    }
    //------------------------------------------ 

    public function show($id)
    {
        $funcionarios = $this->funcionarios->find($id);
        
        if ($funcionarios === null) {
            return response()->json(['erro' => 'Não existe dados para esse Funcionario.'], 404);
        }
        
        return response()->json($funcionarios, 200) ;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request,$id)
    {
         //return 'Cheguei aqui - UPDATE';

       $funcionarios = $this->funcionarios->find($id);

       //    dd($request->nome);
       //    dd($request->file('foto'));
   
           if($funcionarios === null){
               return response()->json(['erro' => 'Impossível realizar a atualização. O funcionario não existe!'], 404);
           }
   
           if($request->method() === 'PATCH') {
               // return ['teste' => 'PATCH'];
   
               $dadosDinamico = [];
   
               foreach ($funcionarios->RegrasFunc() as $input => $regra) {
                   if(array_key_exists($input, $request->all())) {
                       $dadosDinamico[$input] = $regra;
                   }
               }
   
               // dd($dadosDinamico);
   
               $request->validate($dadosDinamico, $this->funcionarios->FeedbackFunc());
           }
           else{
               $request->validate($this->funcionarios->RegrasFunc(), $this->funcionarios->FeedbackFunc());
           }
   
           if($request->file('foto') == true) {
               Storage::disk('public')->delete($funcionarios->foto);
           }
   
           $imagem = $request -> file('foto');
   
           $imagem_url = $imagem -> store('imagem', 'public');
   
          $funcionarios -> update([
               'nome' => $request->nome,
               'foto' => $imagem_url
          ]); // update dos novos dados
   
          return response()->json($funcionarios, 200);
       }

    /**
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $funcionarios = $this -> funcionarios -> find($id);

        if($funcionarios === null){
            return response()->json(['erro' => 'Impossível deleter este registro. O funcionario não existe!'], 404);
        }

        Storage::disk('public')->delete($funcionarios->foto);

        // return 'Cheguei aqui - DESTROY';
        $funcionarios->delete();

        return response()->json(['msg' => 'O registro foi removido com sucesso'], 200);  
    }
}
