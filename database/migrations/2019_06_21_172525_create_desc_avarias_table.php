<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescAvariasTable extends Migration{
    public function up(){
        Schema::create('desc_avarias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('local_avaria_id')->unsigned();
            $table->integer('tipo_avaria_id')->unsigned();
            $table->integer('verificacao_id')->unsigned();
            $table->text('obs')->nullable();
            $table->timestamps();

            $table->foreign('local_avaria_id')->references('id')->on('local_avarias')->onDelete('cascade');
            $table->foreign('tipo_avaria_id')->references('id')->on('tipo_avarias')->onDelete('cascade');
            $table->foreign('verificacao_id')->references('id')->on('verificacoes')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('desc_avarias');
    }
}
