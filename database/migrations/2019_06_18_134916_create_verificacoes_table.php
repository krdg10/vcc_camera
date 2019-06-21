<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificacoesTable extends Migration{
    public function up(){
        Schema::create('verificacoes', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('entrada_id');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('entrada_id')->references('id')->on('entradas');
        });
    }

    public function down(){
        Schema::dropIfExists('verificacoes');
    }
}
