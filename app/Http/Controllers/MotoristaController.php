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
        $motoristas = DB::table('motoristas')->orderBy('nome')->paginate(5);
        return view('motorista.show', compact('motoristas'));
    }
    public function busca(Request $request){
        if($request->nome == null && $request->cpf == null && $request->codigo_empresa == null && $request->codigo_transdata == null){
            $motoristas = DB::table('motoristas')->orderBy('nome')->paginate(5);
            return view('motorista.show', compact('motoristas'));
        }
       /* if ($request->nome != null && $request->cpf != null && $request->codigo_empresa != null && $request->codigo_transdata != null){
            $motoristas = DB::table('motoristas')->where('cpf', $request->cpf)->where('nome', 'like', '%' . $request->nome . '%')->where('codigo_transdata',  $request->codigo_transdata)->where('codigo_empresa', $request->codigo_empresa)->orderBy('nome')->paginate(5);
        }
        else if ($request->nome != null && $request->cpf != null && $request->codigo_empresa){
            $motoristas = DB::table('motoristas')->where('cpf', $request->cpf)->where('nome', 'like', '%' . $request->nome . '%')->where('codigo_empresa', $request->codigo_empresa)->orderBy('nome')->paginate(5);
        }
        else if ($request->nome != null && $request->cpf != null && $request->codigo_transdata){
            $motoristas = DB::table('motoristas')->where('cpf', $request->cpf)->where('nome', 'like', '%' . $request->nome . '%')->where('codigo_transdata', $request->codigo_transdata)->orderBy('nome')->paginate(5);
        }
        else if ($request->nome != null && $request->codigo_transdata != null && $request->codigo_empresa){
            $motoristas = DB::table('motoristas')->where('codigo_transdata', $request->codigo_transdata)->where('nome', 'like', '%' . $request->nome . '%')->where('codigo_empresa', $request->codigo_empresa)->orderBy('nome')->paginate(5);
        }
        else if ($request->codigo_transdata != null && $request->cpf != null && $request->codigo_empresa){
            $motoristas = DB::table('motoristas')->where('codigo_transdata', $request->codigo_transdata)->where('cpf', $request->cpf)->where('codigo_empresa', $request->codigo_empresa)->orderBy('nome')->paginate(5);
        }
        else if ($request->nome != null && $request->cpf != null ){
            $motoristas = DB::table('motoristas')->where('nome', 'like', '%' . $request->nome . '%')->where('cpf', $request->cpf)->orderBy('nome')->paginate(5);
        }
        else if ($request->nome != null && $request->codigo_empresa != null ){
            $motoristas = DB::table('motoristas')->where('nome', 'like', '%' . $request->nome . '%')->where('codigo_empresa', $request->codigo_empresa)->orderBy('nome')->paginate(5);
        }
        else if ($request->nome != null && $request->codigo_transdata != null ){
            $motoristas = DB::table('motoristas')->where('nome', 'like', '%' . $request->nome . '%')->where('codigo_transdata', $request->codigo_transdata)->orderBy('nome')->paginate(5);
        }
        else if ($request->cpf != null && $request->codigo_transdata != null ){
            $motoristas = DB::table('motoristas')->where('cpf', $request->cpf)->where('codigo_transdata', $request->codigo_transdata)->orderBy('nome')->paginate(5);
        }
        else if ($request->cpf != null && $request->codigo_empresa != null ){
            $motoristas = DB::table('motoristas')->where('cpf', $request->cpf)->where('codigo_empresa', $request->codigo_empresa)->orderBy('nome')->paginate(5);
        }
        else if ($request->codigo_empresa != null && $request->codigo_transdata != null ){
            $motoristas = DB::table('motoristas')->where('codigo_empresa', $request->codigo_empresa)->where('codigo_transdata', $request->codigo_transdata)->orderBy('nome')->paginate(5);
        }
        else if ($request->nome !=null){
            $motoristas = DB::table('motoristas')->where('nome', 'like', '%' . $request->nome . '%')->orderBy('nome')->paginate(5);
        }
        else{
            $motoristas = DB::table('motoristas')->where('cpf', $request->cpf)->orWhere('codigo_empresa', $request->codigo_empresa)->orWhere('codigo_transdata', $request->codigo_transdata)->orderBy('nome')->paginate(5);
        }*/
        $cpf = $request->cpf;
        $nome = $request->nome;
        $codigo_empresa = $request->codigo_empresa;
        $codigo_transdata = $request->codigo_transdata;
        $motoristas = DB::table('motoristas')->when($request->cpf,function($query, $cpf){
                            $query->where('cpf', $cpf);
                        })
                        ->when($request->nome,function($query, $nome){
                            $query->where('nome', 'like', '%' . $nome . '%');
                        })
                        ->when($request->codigo_empresa, function($query, $codigo_empresa){
                            $query->where('codigo_empresa', $codigo_empresa);
                        })
                        ->when($request->codigo_transdata, function($query, $codigo_transdata){
                            $query->where('codigo_transdata', $codigo_transdata);
                        })
                        ->orderBy('nome')
                        ->paginate(5);
                        //https://cursos.alura.com.br/forum/topico-consulta-com-filtro-via-eloquent-orm-35886
        //$motoristas = DB::table('motoristas')->where('cpf', $request->cpf)->orWhere('codigo_empresa', $request->codigo_empresa)->orWhere('codigo_transdata', $request->codigo_transdata)->orWhere('nome', $request->nome)->orderBy('nome')->paginate(5);
        //deixei um count na view como verificação. Podia mandar mensagem, mas ia ter que colocar todo aquele código lá. 
        //O problema: quando abrir view, se não tiver nada cadastrado, vai aparecer a mensagem como se fosse busca
        return view('motorista.busca', ['motoristas' => $motoristas, 'nome' => $request->nome, 
        'cpf' => $request->cpf, 'codigo_empresa' => $request->codigo_empresa, 'codigo_transdata' => $request->codigo_transdata]);
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
