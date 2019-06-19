<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrosTable extends Migration{
    public function up(){
        Schema::create('carros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('placa');
            $table->string('modelo');
            $table->year('ano');

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('carros');
    }
}
