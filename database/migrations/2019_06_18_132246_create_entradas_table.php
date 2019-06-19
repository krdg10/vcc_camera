<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration{
    public function up(){
        Schema::create('entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('motorista_id')->unsigned();
            $table->integer('carro_id')->unsigned();
            $table->dateTime('horario');

            $table->timestamps();

            $table->foreign('motorista_id')->references('id')->on('motoristas')->onDelete('cascade');
            $table->foreign('carro_id')->references('id')->on('carros')->onDelete('cascade');

        });
    }

    public function down(){
        Schema::dropIfExists('entradas');
    }
}
