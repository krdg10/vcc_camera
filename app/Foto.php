<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'fotos';
    public function entrada(){
        return $this->belongsTo(Entrada::class);
    }
}
