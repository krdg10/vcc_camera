<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desc_avarias extends Model
{
    public function verificacao(){
        return $this->hasOne(Verificacao::class);
    }
}
