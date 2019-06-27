<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model{
    protected $table = 'entradas';

    // IRÁ PROCURAR O MOTORISTA ASSOCIADO A ENTRADA
    public function motorista(){
    	return $this->hasOne(\App\Models\Motorista::class, 'id', 'motorista_id');
	}

	// IRÁ PROCURAR O CARRO ASSOCIADO A ENTRADA
    public function carro(){
    	return $this->hasOne(\App\Models\Carro::class, 'id', 'carro_id');
	}

    // IRÁ PROCURAR TODAS AS FOTOS ASSOCIADAS A ENTRADA
    public function fotos(){
        return $this->hasMany(\App\Models\Foto::class);
    }

    // IRÁ PROCURAR TODAS AS VERIFICAÇÕES RELACIONADAS A ENTRADA
    public function verificacoes(){
        return $this->hasMany(\App\Models\Verificacao::class);
    }
}
