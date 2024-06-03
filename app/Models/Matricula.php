<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;


    protected  $table = 'tblmatriculas';
    protected  $primarykey = 'idMatriculas';

    
    public function aluno(){
        return $this->belongsTo(Aluno::class, 'idAluno');
    }
    public function plano(){
        return $this->belongsTo(Plano::class, 'idPlano');
    }
}