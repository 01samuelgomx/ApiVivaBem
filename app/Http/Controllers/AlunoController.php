<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Matricula;
use App\Models\Plano;
use App\Models\Aula;
use App\Models\Aulamatricula;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlunoController extends Controller
{

    public $aluno;
    public $matricula;
    public $plano;


    public function __construct(Aluno $aluno) {
        $this -> aluno = $aluno;
    }
    /**
     * @return Response
     */
    public function index()
    {
        $alunos = $this -> aluno -> all();
        return response()->json($alunos, 200);
    }

    /**
     * @return Response
     */

    /**
     * @param  Request  
     * @return Response
     */
    public function store(Request $request)
    {

        $request -> validate($this->aluno->Regras(), $this->aluno->Feedback());
        $imagem = $request -> file('foto');
        $imagem_url = $imagem -> store('imagem', 'public');


        $alunos = $this->aluno->create([
            'nome' => $request-> nome,
            'foto' => $imagem_url
        ]);

        return response()->json($alunos, 200);
    }

    /**
     * @param  Integer
     * @return Response
     */
    public function show($id)
    {
        $alunos = $this->aluno->find($id);
        if($alunos === null) {
            return response()->json(['error' => 'Não existe dados para esse aluno'], 404); // a URL é válida, mas o recurso que uqer acessar não existe no banco
        }

        return response()->json($alunos, 200) ;
    }

    /**
     * @param  Request 
     * @param  Aluno 
     * @return Response
     */

    public function update(Request $request, $id)
    {
   
       $alunos = $this->aluno->find($id);


        if($alunos === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O aluno não existe!'], 404);
        }

        if($request->method() === 'PATCH') {

            $dadosDinamico = [];

            foreach ($alunos->Regras() as $input => $regra) {
                if(array_key_exists($input, $request->all())) {
                    $dadosDinamico[$input] = $regra;
                }
            }


            $request->validate($dadosDinamico, $this->aluno->Feedback());
        }
        else{
            $request->validate($this->aluno->Regras(), $this->aluno->Feedback());
        }

        if($request->file('foto') == true) {
            Storage::disk('public')->delete($alunos->foto);
        }

        $imagem = $request -> file('foto');

        $imagem_url = $imagem -> store('imagem', 'public');

       $alunos -> update([
            'nome' => $request->nome,
            'foto' => $imagem_url
       ]); // update dos novos dados

       return response()->json($alunos, 200);
    }

    /**
     * @param  Aluno  
     * @return Response
     */

    public function destroy($id)
    {

        $alunos = $this -> aluno -> find($id);

        if($alunos === null){
            return response()->json(['erro' => 'Impossível deleter este registro. O aluno não existe!'], 404);
        }

        Storage::disk('public')->delete($alunos->foto);
        $alunos->delete();
        return response()->json(['msg' => 'O registro foi removido com sucesso'], 200);
    }


// --------------------------------------------------------------------------
//   Matricula e Plano 
// --------------------------------------------------------------------------

// --------------------------------------------------------------------------
//  MATRICULA

    public function getMatriculas($idAluno){
    $matricula = Matricula::where('idAluno',$idAluno)->first();

    if(!$matricula){
        return response()->json(['messsage' => 'Matricula Não encontrada'], 404);
    }

     return response()->json(['matricula' => $matricula], 200);

}

// --------------------------------------------------------------------------
//  PLANO

    public function getPlano($idAluno){
    $matricula = Matricula::where('idAluno',$idAluno)->first();

    if(!$matricula){
        return response()->json(['messsage' => 'Matricula Não encontrada'], 404);
    }

     $plano = Plano::find($matricula->idPlano);
      
     if(!$plano){
        return response()->json(['message' => 'Plano não encontrado'], 404);
     }

     return response()->json(['plano' => $plano], 200);

  }
  // --------------------------------------------------------------------------
  //  Aula

  public function getAula($idAluno)
  {
      // Obter as matrículas do aluno
      $matriculas = Matricula::where('idAluno', $idAluno)->pluck('idMatricula');
  
      // Verificar se não há matrículas para o aluno
      if ($matriculas->isEmpty()) {
          return response()->json(['message' => 'Matrículas não encontradas para o aluno'], 404);
      }
  
      // Obter as aulas com base nas matrículas do aluno
      $aulas = Aula::whereExists(function ($query) use ($idAluno) {

          $query->select(DB::raw(1))
              ->from('tblaulamatricula')
              ->whereColumn('tblaulamatricula.idAula', 'tblaulas.idAula')
              ->where('tblaulamatricula.idAluno', $idAluno);
              
      })->get();
  
      // Verificar se não há aulas encontradas
      if ($aulas->isEmpty()) {
          return response()->json(['message' => 'Aulas não encontradas para o aluno'], 404);
      }
  
      // Retornar as aulas encontradas
      return response()->json(['aulas' => $aulas], 200);

  }