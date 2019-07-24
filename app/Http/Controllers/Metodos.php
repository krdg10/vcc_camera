<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Metodos extends Controller{
    public static function retorno(int $tipo, $msg, $dados = 0){
        $retorno = [
            'tipo' => $tipo,
            'msg' => $msg,
            'dados' => $dados
        ];
        return json_encode($retorno);
    }

    // ['valor' => 'valor', 'msg_error' => 'mensagem de erro']
    public static function validacaoCampo($campos){
        $error = [];

        foreach ($campos as $campo)
            if ($campo['valor'] == '' || $campo['valor'] == null)
                $error[] = $campo['msg_error'];
                
        return $error;
    }
}
