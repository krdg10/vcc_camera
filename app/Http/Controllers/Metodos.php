<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Metodos extends Controller{

    /**
     *  Metodo que retorna uma array padrão.
     *
     * @version 1.0.0
     * @require arquivo:metodo 0.0.0
     * @param  int code
     * @param  string message
     * @param  array data
     * @return array
     *
     *  @use arquivo:método:linha
    */
    public static function retornoArray(int $code, $message, $data = []){
        $return = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
        return $return;
    }

    
    /**
     * Retorna json.
     * @version 0.0.0
     * @require arquivo:método:0.0.0
     *
     * @param int $code
     * @param string message
     * @param array data
     *
     * @return Json
     *
     *  @use arquivo:método:linha
     *  @use EntradaController:storeRbt:38
    */
    public static function retornoJson(int $code, $message, $data = []){
        $retorno = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
        return json_encode($retorno);
    }

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
