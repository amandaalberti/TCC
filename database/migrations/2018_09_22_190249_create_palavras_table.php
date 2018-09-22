<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalavrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('palavras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('palavra', 46);
            $table->tinyInteger('silabas');
            $table->enum('letra', ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']);
            $table->timestamps();
        });
        DB::statement("ALTER TABLE palavras ADD imagem MEDIUMBLOB AFTER palavra");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('palavras');
    }
}
