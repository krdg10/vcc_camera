<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotosTable extends Migration{
    public function up(){
        Schema::create('fotos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path', 200);
            $table->integer('entrada_id')->unsigned();

            $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');

            $table->timestamps();

        });
    }

    public function down(){
        Schema::dropIfExists('fotos');
    }
}
