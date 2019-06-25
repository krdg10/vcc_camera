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
        $carros = DB::table('carros')->paginate(10);
        return view('carro.show', compact('carros'));
    }
    public function edit($id)
    {
        $Carro = Carro::findOrFail($id);
        return view('carro.edit',compact('Carro'));
    }
  
    public function update(Request $request, $id)
    {
        $Carro = Carro::findOrFail($id);
        $Carro->nome        = $request->nome;
        $Carro->modelo = $request->modelo;
        $Carro->placa    = $request->placa;
        $Carro->ano       = $request->ano;
        $Carro->save();
        return redirect()->route('carro.edit', compact('Carro'))->with('message', 'Product updated successfully!');
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

