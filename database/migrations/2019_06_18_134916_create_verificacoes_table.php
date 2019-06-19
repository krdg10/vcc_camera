<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificacoesTable extends Migration{
    public function up(){
        Schema::create('verificacoes', function (Blueprint $table){
            $table->increments('id');
            $table->boolean('verificou');
            $table->unsignedInteger('entrada_id');
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('avaria_id');
            $table->timestamps();

            $table->foreign('entrada_id')->references('id')->on('entradas');
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('avaria_id')->references('id')->on('avarias');

        });
    }

    public function down(){
        Schema::dropIfExists('verificacoes');
    }
}
