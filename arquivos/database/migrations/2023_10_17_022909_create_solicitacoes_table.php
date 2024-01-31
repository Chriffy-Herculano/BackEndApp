<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_autonomo');
            $table->date('data');
            $table->time('horario');
            $table->text('descricao');
            $table->enum('status', ['pendente', 'em_progresso', 'concluído']);
            $table->boolean('servico_finalizado')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('users');
            $table->foreign('id_autonomo')->references('id')->on('customers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamento');
    }
}
