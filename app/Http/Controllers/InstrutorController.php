<?php

namespace App\Http\Controllers;
use App\Models\Instrutors;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstrutorController extends Controller
{
    public $instrutors;

    // Definição do método construtor da classe.
    public function __construct(Instrutors $instrutor)
    {
        $this->instrutors = $instrutor;
    }
    //------------------------------------------ 
    /**
     * @return Response
     */
    public function index()
    {
             $instrutores = $this->instrutors->all();

             return response()->json($instrutores, 200);
    }
    //------------------------------------------ 
/**
 * @param  Request  
 * @return Response
 */
public function store(Request $request)
{
    // Valida os dados da requisição com as regras do instrutor
    $request->validate($this->instrutors->RegrasInstrutor(), $this->instrutors->FeedbackInstrutor());

    // Verifica se um arquivo de imagem foi enviado
    if ($request->hasFile('foto')) {
        // Obtém o arquivo de imagem da requisição
        $imagem = $request->file('foto');

        // Armazena a imagem no sistema de arquivos e obtém sua URL
        $imagem_url = $imagem->store('imagem', 'public');
    } else {
        // Define a URL da imagem como null se nenhum arquivo foi enviado
        $imagem_url = null;
        // Ou defina uma URL padrão, se aplicável
    }

    // Cria um novo instrutor com os dados da requisição
    $instrutor = $this->instrutors->create([
        'nome' => $request->nome,
        'email' => $request->email,
        'foto' => $imagem_url
    ]);

    // Retorna o instrutor criado com sucesso
    return response()->json($instrutor, 200);
}
/**
 * Obtém e retorna os dados de um instrutor específico.
 * @param  Integer $id O ID do instrutor a ser recuperado.
 * @return Response
 */
public function show($id)
{
    // Encontra o instrutor pelo ID
    $instrutor = $this->instrutors->find($id);
    
    // Verifica se o instrutor existe
    if ($instrutor === null) {
        // Retorna um erro 404 se o instrutor não existe
        return response()->json(['erro' => 'Não existe dados para esse instrutor.'], 404);
    }
    
    // Retorna os dados do instrutor encontrado
    return response()->json($instrutor, 200);
}

    // crie comentarios simples de uma explicação do processo dentro da estrutura a seguir:
    //------------------------------------------ 
     /**
     * @param  Request  
     * @param  Integer
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Encontra o instrutor pelo ID
        $instrutor = $this->instrutors->find($id);
    
        // Verifica se o instrutor existe
        if ($instrutor === null) {
            // Retorna um erro 404 se o instrutor não existe
            return response()->json(['erro' => 'Impossível realizar a atualização. O instrutor não existe!'], 404);
        }
    
        // Verifica se a requisição é PATCH e constrói dados dinâmicos se necessário
        if ($request->method() === 'PATCH') {
            // Array para armazenar os dados dinâmicos
            $dadosDinamicos = [];
    
            // Itera sobre as regras do instrutor
            foreach ($instrutor->RegrasInstrutor() as $input => $regra) {
                // Verifica se o campo está presente na requisição
                if ($request->has($input)) {
                    // Adiciona o campo e a regra ao array de dados dinâmicos
                    $dadosDinamicos[$input] = $regra;
                }
            }
    
            // Valida os dados dinâmicos da requisição
            $request->validate($dadosDinamicos, $this->instrutors->FeedbackInstrutor());
        } else {
            // Valida todos os campos se a requisição não for PATCH
            $request->validate($this->instrutors->RegrasInstrutor(), $this->instrutors->FeedbackInstrutor());
        }
    
        // Deleta a imagem antiga se um novo arquivo de imagem foi enviado
        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($instrutor->foto);
        }
    
        // Armazena a nova imagem e obtém sua URL
        $imagem = $request->file('foto');
        $imagem_url = $imagem->store('imagem', 'public');
    
        // Atualiza os dados do instrutor
        $instrutor->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'foto' => $imagem_url
        ]);
    
        // Retorna o instrutor atualizado
        return response()->json($instrutor, 200);
    }
    
    //------------------------------------------ 
    /**
     * @param  Integer
     * @return Response
     */
    public function destroy($id)
    {
        $instrutores = $this -> instrutors -> find($id);
        
        //------------------------------------------ 
        
        if($instrutores === null){
            return response()->json(['erro' => 'Impossível deleter este registro. O instrutor não existe!'], 404);
        }
        
        //------------------------------------------ 

        Storage::disk('public')->delete($instrutores->foto);
        $instrutores->delete();

        return response()->json(['msg' => 'O registro foi removido com sucesso'], 200);
    }
}
