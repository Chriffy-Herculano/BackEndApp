<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAvaliacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente'); // Foreign key to reference another table
            $table->unsignedBigInteger('id_autonomo'); // Foreign key to reference another table
            $table->float('avaliacao'); // Assuming 'avaliacao' is a float type
            $table->text('comentario')->nullable(); // Assuming 'comentario' is a text type

            // Define foreign key constraints
            $table->foreign('id_cliente')->references('id')->on('users');
            $table->foreign('id_autonomo')->references('id')->on('customers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avaliacao');
    }
}
