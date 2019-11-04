<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Motorista;

class MotoristaController extends Controller{ 

    public function storeMotorista(Request $request){
        $validator = Validator::make($request->all(), MotoristaController::rulesMotorista(NULL));

        if ($validator->fails()) {
            //dd($validator->failed()["cpf"]["Cpf"]);
            //if failed cpf exists; request->cpf =''; limpa assim
            return redirect()->back()->withErrors($validator)->with('resposta', $request->all());
        }
        
        //https://stackoverflow.com/questions/47750807/laravel-rule-validation-unique-for-id
        //https://laravel.com/docs/5.8/facades
        //https://laravel.com/docs/5.8/validation#customizing-the-validation-attributes
        //https://stackoverflow.com/questions/24328850/laravel-validate-error
        //https://stackoverflow.com/questions/25573617/laravel-validation-check-why-validator-failed

        try {
            $motorista = new Motorista;
            $motorista->nome = $request->nome;
            $motorista->cpf = $request->cpf;
            $motorista->data_nascimento = $request->data_nascimento;
            $motorista->codigo_empresa = $request->codigo_empresa;
            $motorista->codigo_transdata = $request->codigo_transdata;
           
            $motorista->save();
            
            return redirect()->route('motorista.lista')->with('message', 'Sucesso ao cadastrar motorista!');
        } catch (Exception $e) {
            return redirect()->route('motorista.lista')->with('message', 'Ocorreu um erro ao cadastar o motorista.');
        }
    }
    
    public function listaMotoristas(){
        $motoristas = MotoristaController::getAllDriversOrdernedByName();
        return view('motorista.listaMotoristas', compact('motoristas'));
    }

    public function buscaMotorista(Request $request){
        $redirect = MotoristaController::verifyIfSearchIsEmpty($request);
        if(isset($redirect)){
            return $redirect;
        }
        
        $cpf = $request->cpf;
        $nome = $request->nome;
        $codigo_empresa = $request->codigo_empresa;
        $codigo_transdata = $request->codigo_transdata;
        $ativo = $request->ativo;
        $motoristas = MotoristaController::getSearchResults($request);
                    
        return view('motorista.busca', ['motoristas' => $motoristas, 'nome' => $request->nome, 
        'cpf' => $request->cpf, 'codigo_empresa' => $request->codigo_empresa, 'codigo_transdata' => $request->codigo_transdata, 'ativo' => $request->ativo]);
    }

    public function editMotorista($id){
        $Motorista = Motorista::findOrFail($id);
        return view('motorista.edit',compact('Motorista'));
    }
  
    public function updateMotorista(Request $request, $id){
        $validator = Validator::make($request->all(), MotoristaController::rulesMotorista($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        

        $Motorista = Motorista::findOrFail($id);
        $Motorista->nome               = $request->nome;
        $Motorista->cpf                = $request->cpf;
        $Motorista->data_nascimento    = $request->data_nascimento;
        $Motorista->codigo_empresa     = $request->codigo_empresa;
        $Motorista->codigo_transdata   = $request->codigo_transdata;
        $Motorista->save();

        return redirect()->route('motorista.edit', compact('Motorista'))->with('message', 'Motorista Atualizado com Sucesso!');
    }

    public function deleteMotorista($id){
        $Motorista = Motorista::findOrFail($id);
        return view('motorista.delete',compact('Motorista'));
    }

    public function destroyMotorista($id){
        $Motorista = Motorista::findOrFail($id);
        $Motorista->ativo = 0;
        $Motorista->update();
        return redirect()->route('motorista.lista')->with('message', 'Motorista Deletado Com Sucesso!');
    }

    public function getAllDriversOrdernedByName(){
        return Motorista::where('ativo', 1)->orderBy('nome')->paginate(5);
    }

     public function verifyIfSearchIsEmpty($request){
        if($request->nome == null && $request->cpf == null && $request->codigo_empresa == null && $request->codigo_transdata == null && $request->ativo == null){
            return MotoristaController::listaMotoristas();
        }
        return;
    }

    public function getSearchResults($request){
        return DB::table('motoristas')->when($request->cpf,function($query, $cpf){
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
    }

    public function rulesMotorista($motorista){
        return [
            'nome' => 'required|max:250',
            'cpf' => 'required|cpf|max:11|unique:motoristas,cpf,'.$motorista,
            'data_nascimento' => 'required|date',
            'codigo_empresa' => 'required|digits:4|unique:motoristas,codigo_empresa,'.$motorista,
            'codigo_transdata' => 'required|digits:5|unique:motoristas,codigo_transdata,'.$motorista
        ];
    }
}
