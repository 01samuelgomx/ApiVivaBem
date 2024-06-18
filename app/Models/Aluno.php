<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'data_nascimento', 'sexo', 'cpf', 'rg', 'endereco', 'cidade', 'estado',
        'cep', 'telefone', 'email', 'profissao', 'estado_civil', 'altura', 'peso',
        'tipo_sanguineo', 'alergias', 'medicamentos_uso', 'cirurgias_previas', 'lesoes_previas',
        'objetivo', 'frequencia_semanal', 'horario_preferencial', 'data_matricula', 'tipo_plano',
        'status', 'foto'
    ];

    public function regras()
    {
        return [
            'nome' => 'required|min:3',
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'cpf' => 'nullable|unique:alunos,cpf,'.$this->id.',id|cpf',
            'rg' => 'nullable|unique:alunos,rg,'.$this->id.',id',
            'endereco' => 'nullable',
            'cidade' => 'nullable',
            'estado' => 'nullable|size:2',
            'cep' => 'nullable|regex:/^\d{5}-\d{3}$/',
            'telefone' => 'nullable',
            'email' => 'nullable|email|unique:alunos,email,'.$this->id.',id',
            'profissao' => 'nullable',
            'estado_civil' => 'nullable|in:Solteiro,Casado,Divorciado,Viúvo,Outro',
            'altura' => 'nullable|numeric|min:0',
            'peso' => 'nullable|numeric|min:0',
            'tipo_sanguineo' => 'nullable|max:3',
            'alergias' => 'nullable',
            'medicamentos_uso' => 'nullable',
            'cirurgias_previas' => 'nullable',
            'lesoes_previas' => 'nullable',
            'objetivo' => 'nullable',
            'frequencia_semanal' => 'nullable|numeric|min:0',
            'horario_preferencial' => 'nullable',
            'data_matricula' => 'nullable|date',
            'tipo_plano' => 'nullable',
            'status' => 'nullable|in:Ativo,Inativo',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Exemplo de validação de imagem
        ];
    }
    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute deve ter pelo menos :min caracteres',
            'date' => 'O campo :attribute deve ser uma data válida',
            'in' => 'O campo :attribute deve ser um dos valores permitidos',
            'cpf' => 'O CPF informado é inválido',
            'unique' => 'O :attribute informado já está em uso',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido',
            'numeric' => 'O campo :attribute deve ser um valor numérico',
            'size' => 'O campo :attribute deve ter :size caracteres',
            'regex' => 'O campo :attribute deve estar no formato correto',
            'image' => 'O arquivo enviado deve ser uma imagem',
            'mimes' => 'Formatos permitidos para a foto: jpeg, png, jpg, gif',
            'max' => 'O tamanho máximo do arquivo é :max kilobytes'
        ];
    }
}
