<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Carro;

class CarroController extends Controller
{
    public function index()
    {
        return view('carro.index');
    }
    public function store(Request $request){
        $carro = new Carro;
        if(!$request->nome){
            $error[] = 'Coloque algum nome para seu carro!';
        }
        if(!$request->placa){
            $error[] = 'Insira alguma placa!';
        }
        if(!$request->modelo){
            $error[] = 'Insira o modelo!';
        }
        if(!$request->ano){
            $error[] = 'Coloque o ano do veículo!';
        }
        if(isset($error)){
            return redirect()->back()->with('error', $error);
        }

        $carro->nome = $request->nome;
        $carro->placa = $request->placa;
        $carro->modelo = $request->modelo;
        $carro->ano = $request->ano;
        $carro->save();
        
        return redirect()->back()->with('message', 'Sucesso ao cadastrar carro!');
    }
    public function show(){
        $carros = DB::table('carros')->orderBy('nome')->paginate(5);
        return view('carro.show', compact('carros'));
    }
    
    public function busca(Request $request){
        if($request->nome == null && $request->modelo == null && $request->placa == null && $request->ano == null){
            $carros = DB::table('carros')->orderBy('nome')->paginate(5);
            return view('carro.show', compact('carros'));
        }
        
        $placa = $request->placa;
        $nome = $request->nome;
        $modelo = $request->modelo;
        $ano = $request->ano;
        $carros = DB::table('carros')->when($request->placa,function($query, $placa){
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
                        ->orderBy('nome')
                        ->paginate(5);
        
        return view('carro.busca', ['carros' => $carros, 'nome' => $request->nome, 
        'placa' => $request->placa, 'modelo' => $request->modelo, 'ano' => $request->ano]);
    }
    public function edit($id)
    {
        $Carro = Carro::findOrFail($id);
        return view('carro.edit',compact('Carro'));
    }
  
    public function update(Request $request, $id)
    {
        if(!$request->nome){
            $error[] = 'Coloque algum nome para seu carro!';
        }
        if(!$request->placa){
            $error[] = 'Insira alguma placa!';
        }
        if(!$request->modelo){
            $error[] = 'Insira o modelo!';
        }
        if(!$request->ano){
            $error[] = 'Coloque o ano do veículo!';
        }
        if(isset($error)){
            return redirect()->back()->with('error', $error);
        }

        $Carro = Carro::findOrFail($id);
        $Carro->nome        = $request->nome;
        $Carro->modelo = $request->modelo;
        $Carro->placa    = $request->placa;
        $Carro->ano       = $request->ano;
        $Carro->save();
        return redirect()->route('carro.edit', compact('Carro'))->with('message', 'Carro Atualizado com Sucesso!');
    }

    public function delete($id)
    {
        $Carro = Carro::findOrFail($id);
        return view('carro.delete',compact('Carro'));
    }
    public function destroy($id){
        $Carro = Carro::findOrFail($id);
        $Carro->delete();
        return redirect()->route('carro.show');
    }

}

