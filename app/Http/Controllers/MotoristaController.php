<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Motorista;

class MotoristaController extends Controller
{
    public function index()
    {
        return view('motorista.index');
    }
    public function store(Request $request){
        $motorista = new Motorista;
        if(!$request->nome){
            $error[] = 'Coloque algum nome para seu motorista!';
        }

        $motorista->nome = $request->nome;
        $motorista->cpf = $request->cpf;
        $motorista->data_nascimento = $request->data_nascimento;
        $motorista->codigo_empresa = $request->codigo_empresa;
        $motorista->codigo_transdata = $request->codigo_transdata;
        $motorista->save();q'
        
        return redirect()->back()->with('message', 'Sucesso ao cadastrar motorista!');
    }
}
