<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'fotos';
    protected $fillable = ['entrada_id', 'path'];

    public function entrada(){
        return $this->belongsTo(Entrada::class);
    }
}
