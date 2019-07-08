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
use Illuminate\Support\Facades\DB;


class VerificacaoController extends Controller{

    public function index(){}

    public function create($id){}

    public function store(Request $request, $id){
        // VERIFICA SE A ENTRADA JÁ FOI VERIFICADA
        if (DB::table('verificacoes')->where('entrada_id', '=', $id)->exists()){
            $error[] = 'Essa entrada já foi verificada!';
            return redirect('/entrada')->with('error', $error);
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

                // $avaria->save();
            }
        }
        return redirect('/entrada')->with('message', 'Sucesso ao criar o seu negócio!');
    }

    public function show($id){
        // VERIFICA SE A ENTRADA JÁ FOI VERIFICADA
        if (DB::table('verificacoes')->where('entrada_id', '=', $id)->exists()){
            $error[] = 'Essa entrada já foi verificada!';
            return redirect('/entrada')->with('error', $error);
        }
        
        $tipoAvariaController = new TipoAvariaController;
        $localAvariasController = new LocalAVariasController;
        $entradaController = new EntradaController;

        $tipoAvarias = $tipoAvariaController->show();
        $localAvarias = $localAvariasController->show();
        $entradas = $entradaController->show($id);
        
        return view('verificacao.create', compact('tipoAvarias', 'localAvarias', 'entradas'));
    }

    public function edit($id){
        $entradaController = new EntradaController;
        $tipo_avariaController = new TipoAvariaController;
        $local_avariasController = new LocalAVariasController;
        
        $verificacao = Verificacao::find($id);
        $entradas = $entradaController->show($verificacao->entrada_id);
        $tipo_avarias = $tipo_avariaController->show();
        $local_avarias = $local_avariasController->show();

        return view('verificacao.edit', compact('verificacao', 'tipo_avarias', 'local_avarias', 'entradas'));
    }

    public function exibir($id){
        $tipo_avariaController = new TipoAvariaController;
        $local_avariasController = new LocalAVariasController;
        $entradaController = new EntradaController;

        $verificacao = Verificacao::find($id);
        $tipo_avarias = $tipo_avariaController->show();
        $local_avarias = $local_avariasController->show();
        $fotos = $entradaController->show($verificacao->entrada_id)->fotos;

        return view('verificacao.exibir', compact('verificacao', 'tipo_avarias', 'local_avarias', 'fotos'));
    }

    public function update(Request $request, $id){
        $avaria = Desc_avarias::findOrFail($id);;
        $avaria->local_avaria_id = $request->localAvaria;
        $avaria->tipo_avaria_id = $request->tipoAvaria;
        $avaria->obs = $request->obs;
        $avaria->save();
        
        return redirect()->back()->with('message', 'Sucesso ao atualizar a avaria!');
    }

    public function destroy($id){}
}
