<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verificacao;

class VerificacaoController extends Controller{

    public function index(){
        $tipoAvariaController = new TipoAvariaController;
        $localAvariasController = new LocalAVariasController;
        $tipoAvarias = $tipoAvariaController->show();
        $localAvarias = $localAvariasController->show();
        return view('verificacao.viewVerificacao', compact('tipoAvarias', 'localAvarias'));
    }

    public function create(){
        //
    }

    public function store(Request $request){
        return dd($request);
    }

    public function show($id){
        //
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
