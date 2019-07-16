<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotoristasTable extends Migration{
    public function up(){
        Schema::create('motoristas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cpf', 45)->unique();
            $table->date('data_nascimento');
            $table->string('codigo_empresa', 4)->unique();
            $table->string('codigo_transdata', 5)->unique();
            $table->boolean('ativo')->default(1);
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('motoristas');
    }
}
