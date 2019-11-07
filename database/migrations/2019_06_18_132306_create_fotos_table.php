<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotosTable extends Migration{
    public function up(){
        Schema::create('fotos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entrada_id')->unsigned();
            $table->string('path', 200);
            $table->string('legenda', 200)->default('Imagem');
            $table->timestamps();

            $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('fotos');
    }
}
