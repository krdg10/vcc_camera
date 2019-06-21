<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescAvariasTable extends Migration{
    public function up(){
        Schema::create('desc_avarias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('avaria_id')->unsigned();
            $table->integer('tipoAvaria_id')->unsigned();
            $table->integer('vericacao_id')->unsigned();
            $table->string('obs');

            $table->timestamps();

            $table->foreign('avaria_id')->references('id')->on('avarias');
            $table->foreign('tipoAvaria_id')->references('id')->on('tipoAvarias');
            $table->foreign('vericacao_id')->references('id')->on('vericacao');
        });
    }

    public function down(){
        Schema::dropIfExists('desc_avarias');
    }
}
