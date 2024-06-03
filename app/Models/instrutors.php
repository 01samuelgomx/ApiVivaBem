<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrutors extends Model
{
    use HasFactory;
    
    // Specifying the table name
    protected $table = 'instrutors';
    
    // Specify the fillable fields
    protected $fillable = ['nome', 'foto', 'email'];

    // Validation rules for Instrutor data
    public function RegrasInstrutor(){
        return [
            'nome'  => 'required|unique:instrutors,nome,'.$this->id.'|min:3',
            'email' => 'required|email|unique:instrutors,email,'.$this->id,
            'foto'  => 'required|file|mimes:png,jpg,jpeg,gif'
        ];        
    }
    //mensagens que serão passadas caso os dados não forem corretos ou inconsistêntes
    public function FeedbackInstrutor(){        
        return [
            'required'      => 'O campo :attribute é obrigatório!',
            'foto.mimes'    => 'O arquivo deve ser uma imagem do tipo PNG ou JPG',
            'nome.unique'   => 'O nome do instrutor já existe!',
            'email.unique'   => 'Esse email de instrutor já existe!',
            'nome.min'      => 'O nome do instrutor deve conter mais que 3 caracteres!'
        ];
    }

}
