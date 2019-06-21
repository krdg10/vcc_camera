<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entrada;
use App\Models\Carro;
use App\Models\Motorista;
use App\Models\Foto;

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
        for($i = 0; $i < count($request->foto); $i++){
            $foto = new Foto;
            \Log::info($foto);

            $foto->path = $request->foto[$i];
            $foto->entrada()->associate($entrada);
            $foto->save();
        }
        
        return redirect()->back()->with('message', 'Sucesso ao cadastrar entrada!');
    }
}
