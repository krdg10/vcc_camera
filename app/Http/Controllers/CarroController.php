<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Carro;

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
}

