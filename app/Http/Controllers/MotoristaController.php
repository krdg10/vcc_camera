<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

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
        if(!$request->cpf){
            $error[] = 'Coloque o CPF do motorista!';
        }
        if(!$request->data_nascimento){
            $error[] = 'Insira a data de nascimento!';
        }
        if(!$request->codigo_empresa){
            $error[] = 'Insira o Código da Empresa!';
        }
        if(!$request->codigo_transdata){
            $error[] = 'Insira o Código Transdata!';
        }
        if(isset($error)){
            return redirect()->back()->with('error', $error);
        }
        $motorista->nome = $request->nome;
        $motorista->cpf = $request->cpf;
        $motorista->data_nascimento = $request->data_nascimento;
        $motorista->codigo_empresa = $request->codigo_empresa;
        $motorista->codigo_transdata = $request->codigo_transdata;
        $motorista->save();
        
        return redirect()->back()->with('message', 'Sucesso ao cadastrar motorista!');
    }
    public function show(){
        $motoristas = DB::table('motoristas')->paginate(10);
        return view('motorista.show', compact('motoristas'));
    }
    public function edit($id)
    {
        $Motorista = Motorista::findOrFail($id);
        return view('motorista.edit',compact('Motorista'));
    }
  
    public function update(Request $request, $id)
    {
        if(!$request->nome){
            $error[] = 'Coloque algum nome para seu motorista!';
        }
        if(!$request->cpf){
            $error[] = 'Coloque o CPF do motorista!';
        }
        if(!$request->data_nascimento){
            $error[] = 'Insira a data de nascimento!';
        }
        if(!$request->codigo_empresa){
            $error[] = 'Insira o Código da Empresa!';
        }
        if(!$request->codigo_transdata){
            $error[] = 'Insira o Código Transdata!';
        }
        if(isset($error)){
            return redirect()->back()->with('error', $error);
        }
        $Motorista = Motorista::findOrFail($id);
        $Motorista->nome        = $request->nome;
        $Motorista->cpf = $request->cpf;
        $Motorista->data_nascimento    = $request->data_nascimento;
        $Motorista->codigo_empresa       = $request->codigo_empresa;
        $Motorista->codigo_transdata       = $request->codigo_transdata;
        $Motorista->save();
        return redirect()->route('motorista.edit', compact('Motorista'))->with('message', 'Motorista Atualizado com Sucesso!');
    }
    public function delete($id)
    {
        $Motorista = Motorista::findOrFail($id);
        return view('motorista.delete',compact('Motorista'));
    }
    public function destroy($id){
        $Motorista = Motorista::findOrFail($id);
        $Motorista->delete();
        return redirect()->route('motorista.show');
    }
}
