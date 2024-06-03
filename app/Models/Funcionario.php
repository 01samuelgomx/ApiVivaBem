<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    
    //Especificando para qual tabela e campos usaremos a função
    protected $table = 'funcionarios';
    protected $fillable = ['nome', 'foto', 'email'];

    //Campos no banco que receberam os dados via postman
    public function RegrasFunc(){
        return [
            'nome'  => 'required|unique:Funcionarios,nome,'.$this->id.'|min:3',
            'email' => 'required|email|unique:Funcionarios,email,'.$this->id,
            'foto'  => 'required|file|mimes:png,jpg'
        ];        
    }

    //mensagens que serão passadas caso os dados não forem corretos ou inconsistêntes
    public function FeedbackFunc(){        
        return [
            'required'      => 'O campo :attribute é obrigatório!',
            'foto.mimes'    => 'O arquivo deve ser uma imagem do tipo PNG ou JPG',
            'nome.unique'   => 'O nome do Funcionario já existe!',
            'email.unique'   => 'Esse email de Funcionario já existe!',
            'nome.min'      => 'O nome do Funcionario deve conter mais que 3 caracteres!'
        ];
    }

}
