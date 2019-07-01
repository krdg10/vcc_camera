<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desc_avarias;
use App\Models\Verificacao;

class DescAvariasController extends Controller{
    public function index(){
    }

    public function create(){
        //
    }

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
         /*   $expediente->negocio()->associate($negocio);*/
            $avaria->save();
        }
        return redirect()->back()->with('message', 'Sucesso ao inserir novas avarias!');
        //return redirect()->route('verificacao/edit', ['id' => 'verificacao->id']);
    }

    public function show($id=""){
        return Desc_avarias::all();
    }

    public function edit($id){
        //
    }

    public function update(Request $request, $id){
        
    }

    public function destroy($id){
        $avarias = Desc_avarias::findOrFail($id);
        $avarias->delete();
        return redirect()->back()->with('message', 'Sucesso ao excluir a avaria!');
    }
}
