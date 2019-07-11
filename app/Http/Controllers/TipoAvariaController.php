<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo_avarias;

class TipoAvariaController extends Controller{
    public function index(){
        $tipo_avarias = Tipo_avarias::all();
        // return dd($tipo_avarias);
        return view('avaria.index_tipoAvaria', compact('tipo_avarias'));
    }

    public function create(){}

    public function store(Request $request){
        // VERIFICA SE EXISTE ALGO CADASTRADO COM ESSE NOME
        if(Tipo_avarias::where('tipo', $request->tipoAvaria)->count() > 0){
            $error[] = "Tipo de Avaria $request->tipoAvaria já existe!";
            return redirect()->back()->with('error', $error);
        }

        try {
            $tipo_avarias = new Tipo_avarias;
            $tipo_avarias->tipo = $request->tipoAvaria;
            $tipo_avarias->save();
            //return Metodos::retorno(1, 'Sucesso ao adicinar "' . $request->tipo . '".', $tipo_avarias);
            return redirect()->back()->with('message', 'Sucesso ao cadastrar novo tipo de avaria!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Falha ao cadastrar novo tipo de avaria!');
        }
    }

    public function show($id=false){
        if($id)
            return Tipo_avarias::where('id', '=', $id);
        else
            return Tipo_avarias::all();

    }

    public function edit($id){}

    public function update(Request $request, $id){}

    public function destroy($id){
        try {
            $d = Tipo_avarias::find($id);
            $d->delete();
            return Metodos::retorno(1, 'Sucesso ao eliminar');
        } catch (Exception $e) {
            return Metodos::retorno(0, 'Erro ao eliminar');     
        }

    }
}
