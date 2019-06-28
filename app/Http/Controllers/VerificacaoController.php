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

    public function index(){
    }

    public function create($id){

    }

    public function store(Request $request, $id){
        if (DB::table('verificacoes')->where('entrada_id', '=', $id)->exists())
            $error[] = 'Essa entrada já foi verificada!';
        
        if(isset($error))
            return redirect()->back()->with('error', $error);
        
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

    public function edit($id)
    {
        $Verificacao = Verificacao::findOrFail($id);
        $User = User::findOrFail($Verificacao->users_id);
        $entradas = Entrada::findOrFail($Verificacao->entrada_id);
        $Avarias = DB::table('desc_avarias')->where('verificacao_id', '=', $Verificacao->id)->get();
        $Fotos = DB::table('fotos')->where('entrada_id', '=', $entradas->id)->get();
        $Motoristas = DB::table('motoristas')->where('id', '=', $entradas->motoristas_id)->get();
        $tipoAvaria = Tipo_avarias::all();
        $tipoAvaria2 = Tipo_avarias::all(); //gambiarra
        $localAvaria = Local_avaria::all();
        $localAvaria2 = Local_avaria::all(); //gambiarra


        return view('verificacao.edit', compact('Verificacao', 'localAvaria2', 'tipoAvaria2', 'Motoristas', 'Fotos', 'User', 'entradas', 'Avarias', 'tipoAvaria', 'localAvaria'));
    }

    public function update(Request $request, $id){
      
        $avaria = Desc_avarias::findOrFail($id);;
        
            $avaria->local_avaria_id = $request->localAvaria;
            $avaria->tipo_avaria_id = $request->tipoAvaria;
            $avaria->obs = $request->obs;

            
            $avaria->save();
        
        return redirect()->back()->with('message', 'Sucesso ao atualizar a avaria!');
    }

    public function destroy($id){
        //
    }
}
