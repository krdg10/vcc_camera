<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalAvariasTable extends Migration{
    public function up(){
        Schema::create('local_avarias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('local');

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('local_avarias');
    }
}
