<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatetable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatetable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $primaryKey = 'idUsuario';
    protected $table = 'tblusuarios';
    protected $hidden = ['senha'];
    protected $fillable = ['nome','email', 'senha', 'tipo_usuario_id', 'tipo_usuario_type'];

    public function tipo_usuario(){

        return $this->morphTo('tipo_usuario','tipo_usuario_type','tipo_usuario_id');

    }
}
