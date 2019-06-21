<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Entrada;
use App\Carro;
use App\Motorista;

class EntradaController extends Controller
{
    public function index()
    {   
        $motorista = new Motorista;
        $carro = new Carro;
        $motorista = Motorista::all();
        $carro = Carro::all();
        return view('entrada.index', compact('motorista', 'carro'));
    }
    public function store(Request $request){
        $entrada = new Entrada;
        if(!$entrada->nome){
            $error[] = 'Coloque algum nome para seu motorista!';
        }

        $entrada->motorista_id = $request->motorista;
        $entrada->carro_id = $request->carro;
        $entrada->horario = $request->horario;
        
        $entrada->save();
        
        return redirect()->back()->with('message', 'Sucesso ao cadastrar entrada!');
    }
}
