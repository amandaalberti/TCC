<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespostaExerciciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resposta_exercicios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aluno_id');
            $table->foreign('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
            $table->smallInteger('tipo');
            $table->enum('letra', ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']);
            $table->boolean('acertou');
            $table->string('palavra', 46);
            $table->string('resposta_certa');
            $table->string('resposta_selecionada');
            $table->timestamp('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resposta_exercicios');
    }
}
