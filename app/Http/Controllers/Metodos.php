<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Metodos extends Controller{
    public static function verificarPublica(){
        // return "public/";
        return "";
    }

    public static function habilitar($id, $colunaId, $tabela){
        $habilitado = Metodos::verificarHabilitado($id, $colunaId, $tabela);
        if ($habilitado) return 2;
        try {
            DB::table($tabela)->where($colunaId, $id)->update(['habilitado' => 1]);
            return 1;   
        } catch (\Exception $e) {
            return 3;
        }
    }

    public static function verificarHabilitado($id, $colunaId, $tabela){
        $habilita = DB::table('usuarios')->where('idUsuario', $id)->first()->habilitado;
        if ($habilita) 
            return true;
        else  
            return false;
    }

    public static function retorno(int $tipo, $msg, $dados = 0){
        $retorno = [
            'tipo' => $tipo,
            'msg' => $msg,
            'dados' => $dados
        ];
        return json_encode($retorno);
    }
}
