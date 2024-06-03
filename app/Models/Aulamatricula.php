<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aulamatricula extends Model
{
    use HasFactory;

    protected $table = 'tblaulamatricula';
    protected $primaryKey = 'idMatricula';

    protected $fillable = [
        'idAula',
        'idAluno',
        'dataAula',
    ];

    public $timestamps = true;
}
