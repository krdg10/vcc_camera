<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verificacao;
use App\Models\Desc_avarias;
use App\Models\Entrada;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class VerificacaoController extends Controller{

    public function index(){
    }

    public function create($id){

    }

    public function store(Request $request, $id){

        
        

        if (DB::table('verificacoes')->where('entrada_id', '=', $id)->exists()){
            $error[] = 'Essa entrada já foi verificada!';
        }
        if(isset($error)){
            return redirect()->back()->with('error', $error);
        }
        $verificacao = new Verificacao;
        $verificacao->verificado = $request->verificado;
        $verificacao->entrada_id = $id;
        $verificacao->users_id = Auth::id();
        $verificacao->save();
        for($i = 0; $i < count($request->local); $i++){
            $avaria = new Desc_avarias;
            $avaria->local_avaria_id = $request->local[$i];
            $avaria->tipo_avaria_id = $request->tipo[$i];
            $avaria->obs = $request->obs[$i];
            $avaria->verificacao_id = $verificacao->id;

         /*   $expediente->negocio()->associate($negocio);*/
            $avaria->save();
        }
        return redirect()->back()->with('message', 'Sucesso ao criar o seu negócio!');
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
