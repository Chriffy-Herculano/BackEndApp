<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutonomoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autonomo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario'); // Chave estrangeira
            $table->string('nome_completo');
            $table->integer('idade');
            $table->string('profissao');
            $table->string('genero');
            $table->string('telefone');
            $table->string('estado');
            $table->string('cidade');
            $table->text('descricao');
            $table->string('foto')->nullable(); // Coluna de foto (pode ser nula)
            $table->timestamps();

            // Chave estrangeira para 'id' na tabela 'usuarios'
            $table->foreign('id_usuario')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autonomo');
    }
}
