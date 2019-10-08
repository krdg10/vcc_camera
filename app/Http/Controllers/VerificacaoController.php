<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Verificacao;
use App\Models\Entrada;
use App\Models\Desc_avarias;
use App\Models\Local_avaria;
use App\Models\Tipo_avarias;
use App\User;

use Illuminate\Support\Facades\Auth;


class VerificacaoController extends Controller{
    public function store(Request $request, $id){
        $redirect = VerificacaoController::verifyIfInputHasVerified($id);
        if(isset($redirect)){
            return $redirect;
        }
        
        $verificacao = new Verificacao;
        $verificacao->entrada_id = $id;
        $verificacao->users_id = Auth::id();
        $verificacao->save();
        if(isset($request->local)){
            for($i = 0; $i < count($request->local); $i++){
                $avaria = new Desc_avarias;
                $avaria->local_avaria_id = $request->local[$i];
                $avaria->tipo_avaria_id = $request->tipo[$i];
                $avaria->obs = $request->obs[$i];
                $avaria->verificacao_id = $verificacao->id;

                $avaria->save();
            }
        }
        return redirect('/entrada')->with('message', 'Sucesso ao verificar entrada!');
    }

    public function show($id){
        $redirect = VerificacaoController::verifyIfInputHasVerified($id);
        if(isset($redirect)){
            return $redirect;
        }

        $tipoAvarias = Tipo_avarias::all();
        $localAvarias = Local_avaria::all();
        $entradas = Entrada::findOrFail($id);
        
        return view('verificacao.create', compact('tipoAvarias', 'localAvarias', 'entradas'));
    }

    public function edit($id){
        $verificacao = Verificacao::findOrFail($id);
        $entradas = Entrada::findOrFail($verificacao->entrada_id);
        $tipo_avarias = Tipo_avarias::all();
        $local_avarias = Local_avaria::all();

        return view('verificacao.edit', compact('verificacao', 'tipo_avarias', 'local_avarias', 'entradas'));
    }

    public function exibir($id){
        $verificacao = Verificacao::findOrFail($id);
        $entradas = Entrada::findOrFail($verificacao->entrada_id);
        $tipo_avarias = Tipo_avarias::all();
        $local_avarias = Local_avaria::all();
        $fotos = $entradas->fotos;

        return view('verificacao.exibir', compact('verificacao', 'entradas', 'tipo_avarias', 'local_avarias', 'fotos'));
    }

    public function update(Request $request, $id){
        $avaria = Desc_avarias::findOrFail($id);
        $avaria->local_avaria_id = $request->localAvaria;
        $avaria->tipo_avaria_id = $request->tipoAvaria;
        $avaria->obs = $request->obs;
        $avaria->save();
        
        return redirect()->back()->with('message', 'Sucesso ao atualizar a avaria!');
    }

    public function verifyIfInputHasVerified($id){
        if (Verificacao::where('entrada_id', '=', $id)->exists()){
            return redirect()->to('/entrada')->with('error', 'Essa entrada já foi verificada!');
        }
        return;
    }
}
