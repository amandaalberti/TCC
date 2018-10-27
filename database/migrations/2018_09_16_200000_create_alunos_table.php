<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 100);
            $table->string('usuario', 50)->unique();
            $table->string('senha');
            $table->date('data_nascimento');
            $table->enum('sexo', ['Masculino', 'Feminino']);
            $table->string('deficiencia', 50);
            $table->string('dificuldades', 500);
            $table->unsignedInteger('professor_id');
            $table->foreign('professor_id')->references('id')->on('professores')->onDelete('cascade');
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
        Schema::dropIfExists('alunos');
    }
}
