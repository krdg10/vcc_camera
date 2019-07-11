<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verificacao extends Model
{
    protected $table = 'verificacoes';

    // IRÁ PROCURAR TODAS AS DECRIÇÕES DE AVARIA QUE REFERENCIA A VERIFICAÇÃO
    public function descAvaria(){
        return $this->hasMany(\App\Models\Desc_avarias::class);
    }
    public function entrada(){
    	return $this->hasOne(\App\Models\Entrada::class, 'id', 'entrada_id');
	}
}
