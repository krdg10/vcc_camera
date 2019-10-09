<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Carro;
use Illuminate\Support\Facades\Validator;


class CarroController extends Controller
{
    public function storeCarro(Request $request){
        $carro = new Carro;
        
        $validator = Validator::make($request->all(), CarroController::rulesCarro(NULL));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $carro->nome = $request->nome;
        $carro->placa = $request->placa;
        $carro->modelo = $request->modelo;
        $carro->ano = $request->ano;
        $carro->rfid = $request->rfid;
        $carro->save();
        
        return redirect()->route('carro.lista')->with('message', 'Sucesso ao cadastrar veículo!');
    }
    
    public function listaCarros(){
        $carros = CarroController::getAllCarsOrdernedByName();
        return view('carro.listaCarros', compact('carros'));
    }
    
    public function buscaCarros(Request $request){
        $redirect = CarroController::verifyIfSearchIsEmpty($request);
        if(isset($redirect)){
            return $redirect;
        }
        
        $placa = $request->placa;
        $nome = $request->nome;
        $modelo = $request->modelo;
        $ano = $request->ano;
        $ativo = $request->ativo;
        $rfid = $request->rfid;
        $carros = CarroController::getSearchResults($request);
        
        return view('carro.busca', ['carros' => $carros, 'nome' => $request->nome, 
        'placa' => $request->placa, 'modelo' => $request->modelo, 'ano' => $request->ano, 'ativo' => $request->ativo, 'rfid' => $request->rfid]);
    }
    public function editCarro($id)
    {
        $Carro = Carro::findOrFail($id);
        return view('carro.edit',compact('Carro'));
    }
  
    public function updateCarro(Request $request, $id)
    {
        $validator = Validator::make($request->all(), CarroController::rulesCarro($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $Carro = Carro::findOrFail($id);
        $Carro->nome        = $request->nome;
        $Carro->modelo = $request->modelo;
        $Carro->placa    = $request->placa;
        $Carro->ano       = $request->ano;
        $Carro->rfid       = $request->rfid;
        $Carro->save();
        return redirect()->route('carro.edit', compact('Carro'))->with('message', 'Veículo Atualizado com Sucesso!');
    }

    public function deleteCarro($id)
    {
        $Carro = Carro::findOrFail($id);
        return view('carro.delete',compact('Carro'));
    }
    public function destroyCarro($id){
        $carro = Carro::findOrFail($id);
        $carro->ativo = 0;
        $carro->save();
        return redirect()->route('carro.lista')->with('message', 'Veículo Deletado Com Sucesso!');
    }

    public function getAllCarsOrdernedByName(){
        return Carro::where('ativo', 1)->orderBy('nome')->paginate(5);
    }

    public function verifyIfSearchIsEmpty($request){
        if($request->nome == null && $request->modelo == null && $request->placa == null && $request->ano == null && $request->ativo == null && $request->rfid == null){
            return CarroController::show();
        }
        return;
    }

    public function getSearchResults($request){
        return DB::table('carros')->when($request->placa,function($query, $placa){
                $query->where('placa', $placa);
                })
                ->when($request->nome,function($query, $nome){
                    $query->where('nome', 'like', '%' . $nome . '%');
                })
                ->when($request->modelo, function($query, $modelo){
                    $query->where('modelo', 'like', '%' . $modelo . '%');
                })
                ->when($request->ano, function($query, $ano){
                    $query->where('ano', $ano);
                })
                ->when($request->rfid, function($query, $rfid){
                    $query->where('rfid', $rfid);
                })
                ->when($request->ativo=='0', function($query, $ativo){
                    $query->where('ativo', 0);
                })
                ->when($request->ativo==null, function($query){
                    $query->where('ativo', 1);
                })
                ->orderBy('nome')
                ->paginate(5);
    }

    public function rulesCarro($placa){
        return [
            'nome' => 'required|max:250',
            'placa' => 'required|max:8|formato_placa_de_veiculo|unique:carros,placa,'.$placa,
            'modelo' => 'required|max:250',
            'ano' => 'required|date_format:Y|after:1900|before:2156',
            'rfid' => 'required|max:250'
        ];
    }

}

