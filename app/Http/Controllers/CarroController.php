<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $carro->nome = $request->nome;
        $carro->placa = $request->placa;
        $carro->modelo = $request->modelo;
        $carro->ano = $request->ano;
        $carro->save();
        
        return redirect()->back()->with('message', 'Sucesso ao cadastrar carro!');
    }
    public function show(){
        $carros = Carro::all();
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
}

