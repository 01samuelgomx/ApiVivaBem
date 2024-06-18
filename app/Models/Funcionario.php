<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    
    //Especificando para qual tabela e campos usaremos a função
    protected $table = 'tblfuncionarios';
    protected $fillable = [
        'nome', 'foto', 'email', 'data_nascimento', 'sexo', 'cpf', 'rg',
        'endereco', 'cidade', 'estado', 'cep', 'telefone', 'cargo',
        'salario', 'data_admissao', 'nivel', 'status'
    ];

    public function RegrasFunc()
    {
        return [
            'nome' => 'required|unique:funcionarios,nome,'.$this->id.'|min:3',
            'email' => 'required|email|unique:funcionarios,email,'.$this->id,
            'foto' => 'required|file|mimes:png,jpg',
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'cpf' => 'nullable|unique:funcionarios,cpf,'.$this->id,
            'rg' => 'nullable|unique:funcionarios,rg,'.$this->id,
            'endereco' => 'nullable',
            'cidade' => 'nullable',
            'estado' => 'nullable',
            'cep' => 'nullable',
            'telefone' => 'nullable',
            'cargo' => 'nullable',
            'salario' => 'nullable|numeric|min:0',
            'data_admissao' => 'nullable|date',
            'nivel' => 'nullable',
            'status' => 'nullable',
        ];
    }

    public function FeedbackFunc()
    {
        return [
            'required' => 'O campo :attribute é obrigatório!',
            'foto.mimes' => 'O arquivo deve ser uma imagem do tipo PNG ou JPG',
            'nome.unique' => 'O nome do Funcionário já existe!',
            'email.unique' => 'Esse email de Funcionário já existe!',
            'nome.min' => 'O nome do Funcionário deve conter mais que 3 caracteres!',
            'email.email' => 'O campo :attribute deve ser um endereço de email válido',
            'data_nascimento.date' => 'O campo :attribute deve ser uma data válida',
            'sexo.in' => 'O campo :attribute deve ser M ou F',
            'cpf.unique' => 'Este CPF já está em uso',
            'rg.unique' => 'Este RG já está em uso',
            'salario.numeric' => 'O campo :attribute deve ser um valor numérico',
            'salario.min' => 'O campo :attribute não pode ser negativo',
            'data_admissao.date' => 'O campo :attribute deve ser uma data válida',
        ];
    }

}
