<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo_avarias;

class TipoAvariaController extends Controller{
    public function index(){
        //
    }

    public function create(){
        //
    }

    public function store(Request $request){
        if(Tipo_avarias::where('tipo', 'like', '%'. $request->tipo .'%')->count() > 0)
            return Metodos::retorno(0, 'Já existe "' . $request->tipo . '" cadastrado.');

        try {
            $tipo_avarias = new Tipo_avarias;
            $tipo_avarias->tipo = $request->tipo;
            $tipo_avarias->save();
            return Metodos::retorno(1, 'Sucesso ao adicinar "' . $request->tipo . '".');
        } catch (Exception $e) {
            return Metodos::retorno(0, 'Erro ao inserir novo tipo');
        }
    }

    public function show($id=""){
        return Tipo_avarias::all();
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
