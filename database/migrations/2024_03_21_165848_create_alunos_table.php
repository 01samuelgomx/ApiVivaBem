<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 30)->unique();
            $table->string('foto', 255)->unique()->nullable();
            $table->date('data_nascimento');
            $table->enum('sexo', ['masculino', 'feminino']);
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20)->unique();
            $table->string('endereco', 100);
            $table->string('cidade', 50);
            $table->string('estado', 2);
            $table->string('cep', 9);
            $table->string('telefone', 15);
            $table->string('email');
            $table->string('profissao');
            $table->enum('estado_civil', ['solteiro', 'casado', 'divorciado', 'separado', 'viúvo', 'amaziado']);
            $table->decimal('altura', 5, 2); 
            $table->decimal('peso', 5, 2 );
            $table->string('tipo_sanguineo', 20);
            $table->text('alergias')->nullable();
            $table->text('medicamentos')->nullable();
            $table->text('cirurgias')->nullable();
            $table->text('lesoes_previas')->nullable();
            $table->text('objetivo');
            $table->string('frequencia_semanal');
            $table->time('horario_preferencial');
            $table->date('data_matricula');
            $table->enum('tipo_plano',['Gold','Premium','Básico']);
            $table->enum('status',['ativo','desativado']);
            $table->timestamps();
        });
        
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alunos');
    }
};
