<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoAvariasTable extends Migration{
    public function up(){
        Schema::create('tipo_avarias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('tipo_avarias');
    }
}
