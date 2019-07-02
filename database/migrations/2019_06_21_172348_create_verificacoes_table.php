<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificacoesTable extends Migration{
    public function up(){
        Schema::create('verificacoes', function (Blueprint $table){
            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->integer('entrada_id')->unsigned();
            $table->boolean('verificado')->default(1);
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('verificacoes');
    }
}
