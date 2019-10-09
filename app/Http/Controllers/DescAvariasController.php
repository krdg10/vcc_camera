<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desc_avarias;
use App\Models\Verificacao;

class DescAvariasController extends Controller{

    public function store(Request $request, $id){
        if(isset($error)){
            return redirect()->back()->with('error', $error);
        }
        $verificacao = Verificacao::findOrFail($id);
        for($i = 0; $i < count($request->local); $i++){
            $avaria = new Desc_avarias;
            $avaria->local_avaria_id = $request->local[$i];
            $avaria->tipo_avaria_id = $request->tipo[$i];
            $avaria->obs = $request->obs[$i];
            $avaria->verificacao_id = $verificacao->id;
            $avaria->save();
        }
        return redirect()->back()->with('message', 'Sucesso ao inserir novas avarias!');
    }

    public function show($id=""){
        return Desc_avarias::all();
    }

    public function destroy($id){
        $avarias = Desc_avarias::findOrFail($id);
        $avarias->delete();
        return redirect()->back()->with('message', 'Sucesso ao excluir a avaria!');
    }
}
