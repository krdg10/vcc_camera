<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verificacao;

class VerificacaoController extends Controller{

    public function index(){
    }

    public function create(){
    }

    public function store(Request $request){
        return dd($request);
    }

    public function show($id){
        $tipoAvariaController = new TipoAvariaController;
        $localAvariasController = new LocalAVariasController;
        $entradaController = new EntradaController;

        $tipoAvarias = $tipoAvariaController->show();
        $localAvarias = $localAvariasController->show();
        $entradas = $entradaController->show($id);
        
        return view('verificacao.create', compact('tipoAvarias', 'localAvarias', 'entradas'));
    }

    public function edit($id){
        //
    }

    public function update(Request $request, $id){
        //
    }

    public function destroy($id){
        //
    }
}
