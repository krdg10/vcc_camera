<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'cpf' => 'unique:motoristas,cpf',
            'codigo_empresa' => 'unique:motoristas,codigo_empresa',
            'codigo_transdata' => 'unique:motoristas,codigo_transdata'
        ]);
        //https://stackoverflow.com/questions/47750807/laravel-rule-validation-unique-for-id
        //https://laravel.com/docs/5.8/facades
        //https://laravel.com/docs/5.8/validation#customizing-the-validation-attributes
        //https://stackoverflow.com/questions/24328850/laravel-validate-error
        //https://stackoverflow.com/questions/25573617/laravel-validation-check-why-validator-failed
        

        if ($validator->fails()) {
            $failedRules = $validator->failed();
            if(isset($failedRules['cpf']['Unique'])){
                $error[]='CPF já cadastrado! Insira outro número.';
            }
            if(isset($failedRules['codigo_empresa']['Unique'])){
                $error[]='Código VCC já cadastrado! Insira outro número.';
            } 
            if(isset($failedRules['codigo_transdata']['Unique'])){
                $error[]='Código Transdata já cadastrado! Insira outro número.';
            } 
           
            return redirect()->back()->with('error', $error);
        }

      
        
    
    
        
        $motorista->nome = $request->nome;
        $motorista->cpf = $request->cpf;
        $motorista->data_nascimento = $request->data_nascimento;
        $motorista->codigo_empresa = $request->codigo_empresa;
        $motorista->codigo_transdata = $request->codigo_transdata;
       
        $motorista->save();
        
        
        return redirect('/motorista/listar')->with('message', 'Sucesso ao cadastrar motorista!');
    }
    public function show(){
        $motoristas = DB::table('motoristas')->where('ativo', 1)->orderBy('nome')->paginate(5);
        return view('motorista.show', compact('motoristas'));
    }
    public function busca(Request $request){
        if($request->nome == null && $request->cpf == null && $request->codigo_empresa == null && $request->codigo_transdata == null && $request->ativo == null){
            $motoristas = DB::table('motoristas')->where('ativo', 1)->orderBy('nome')->paginate(5);
            return view('motorista.show', compact('motoristas'));
        }
      
        $cpf = $request->cpf;
        $nome = $request->nome;
        $codigo_empresa = $request->codigo_empresa;
        $codigo_transdata = $request->codigo_transdata;
        $ativo = $request->ativo;
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
                        ->when($request->ativo=='0', function($query, $ativo){
                            $query->where('ativo', 0);
                        })
                        ->when($request->ativo==null, function($query){
                            $query->where('ativo', 1);
                        })
                        ->orderBy('nome')
                        ->paginate(5);
                    //pensar numa estrategia (se precisa) de buscar ambos ativos e inativos.
        return view('motorista.busca', ['motoristas' => $motoristas, 'nome' => $request->nome, 
        'cpf' => $request->cpf, 'codigo_empresa' => $request->codigo_empresa, 'codigo_transdata' => $request->codigo_transdata, 'ativo' => $request->ativo]);
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
        $Motorista->ativo = 0;
        $Motorista->save();
        return redirect()->route('motorista.show')->with('message', 'Motorista Deletado Com Sucesso!');
    }
}
