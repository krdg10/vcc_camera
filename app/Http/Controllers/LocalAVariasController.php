<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local_avaria;

class LocalAVariasController extends Controller{
    public function index(){
        //
    }

    public function create(){
        //
    }

    public function store(Request $request){
        if(Local_avaria::where('local', 'like', '%'. $request->local .'%')->count() > 0)
            return Metodos::retorno(0, 'Já existe "' . $request->local . '" cadastrado.');

        try {
            $local_avaria = new Local_avaria;
            $local_avaria->local = $request->local;
            $local_avaria->save();
            return Metodos::retorno(1, 'Sucesso ao adicinar "' . $local_avaria . '".', $local_avaria);
        } catch (Exception $e) {
            return Metodos::retorno(0, 'Erro ao inserir "' . $request->local . '".', $e);
        }
    }

    public function show($id=""){
        return Local_avaria::all();
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
