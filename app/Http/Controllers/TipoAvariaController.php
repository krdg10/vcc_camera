<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo_avarias;

class TipoAvariaController extends Controller{
    public function index(){
        $avarias = Tipo_avarias::all();
        $chave = 'tipo';

        return view('avaria.index', compact('avarias', 'chave'));
    }

    public function create(){}

    public function store(Request $request){
            // return Metodos::retorno(1, $request->tipo );
        // VERIFICA SE EXISTE ALGO CADASTRADO COM ESSE NOME
        if(Tipo_avarias::where('tipo','=' , $request->tipo)->count() > 0)
            return Metodos::retorno(1, "Tipo de Avaria $request->tipoAvaria já existe!", $tipo_avarias);

        try {
            $tipo_avarias = new Tipo_avarias;
            $tipo_avarias->tipo = $request->tipo;
            $tipo_avarias->save();
            return Metodos::retorno(1, 'Sucesso ao adicinar "' . $request->tipo . '".', $tipo_avarias);
            // return redirect()->back()->with('message', 'Sucesso ao cadastrar novo tipo de avaria!');
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

    public function update(Request $request, $id){
        // error_log($request->ga);
        // return $request->chave;
            return Metodos::retorno(1, $request->chaveUpdate, $request->chaveUpdate);
        try {
            $u = Tipo_avarias::find($id);
            // $u->tipo = $request->tipo;

            $u->update();

            return Metodos::retorno(1, 'Sucesso ao atualizar!', $u);
        } catch (Exception $e) {
            return Metodos::retorno(1, 'Erro ao atualizar!', $e);
        }
    }

    public function destroy($id){
        try {
            $d = $backup = Tipo_avarias::find($id);
            $d->delete();
            return Metodos::retorno(1, 'Sucesso ao eliminar', $backup);
        } catch (Exception $e) {
            return Metodos::retorno(0, 'Erro ao eliminar');     
        }

    }
}
