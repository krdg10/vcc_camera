<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvariasTable extends Migration{
    public function up(){
        Schema::create('avarias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('frente', 45);
            $table->string('traseira', 45);
            $table->string('esquerda', 45);
            $table->string('direita', 45);
            $table->string('observacao', 45);

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('avarias');
    }
}
