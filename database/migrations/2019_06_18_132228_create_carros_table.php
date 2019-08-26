<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrosTable extends Migration{
    public function up(){
        Schema::create('carros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rfid');
            $table->string('nome');
            $table->string('placa')->unique();
            $table->string('modelo');
            $table->year('ano');
            $table->boolean('ativo')->default(1);

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('carros');
    }
}
