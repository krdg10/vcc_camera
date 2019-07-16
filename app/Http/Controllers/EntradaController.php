<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entrada;
use App\Models\Carro;
use App\Models\Motorista;
use App\Models\Foto;
use App\Models\Verificacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
//quando procurei isDate achei uma coisa assim mas n sabia como usar.



class EntradaController extends Controller{
    public function index(){
        $entradas = Entrada::orderBy('horario', 'desc')->paginate(5);
        return view('entrada.index', compact('entradas'));
    }
    
    public function busca(Request $request){
        if($request->nome == null && $request->carro == null && $request->horario == null && $request->verificado == null && $request->n_verificado == null){
            $entradas = Entrada::orderBy('horario', 'desc')->paginate(5);
            return view('entrada.index', compact('entradas'));
        }
       
        $entradas = Entrada::join('motoristas', 'motoristas.id', '=', 'entradas.motorista_id')
        ->join('carros', 'carros.id', '=', 'entradas.carro_id')
        
        ->when($request->verificado=='1', function($consulta){
            $consulta->join('verificacoes', 'verificacoes.entrada_id', '=', 'entradas.id');
        })
        ->when($request->n_verificado=='1', function($consulta){
            $consulta->whereNotIn('entradas.id', DB::table('verificacoes')->select('entrada_id'));
        })
        ->when($request->nome,function($consulta, $nome){
            $consulta->where('motoristas.nome', 'like', '%' . $nome . '%');
        })
        ->when($request->horario,function($consulta, $horario){
            $consulta->where('entradas.horario', $horario);
        })
        ->when($request->carro,function($consulta, $carro){
            $consulta->where('carros.nome', $carro);
        })
        ->orderBy('entradas.horario', 'desc')
        ->paginate(5, ['entradas.id', 'entradas.carro_id', 'entradas.motorista_id', 'entradas.horario']);
        //podia pegar carros.nome direto etc mas ia divergir do que tá na view.

        return view('entrada.busca', ['entradas' => $entradas, 'nome' => $request->nome, 
        'horario' => $request->horario, 'carro' => $request->carro, 'verificado' => $request->verificado, 'n_verificado' => $request->n_verificado]);
    }

    public function store(Request $request){
        $entrada = new Entrada;
        $allowedfileExtension=['jpg','png','gif'];
        if(!$request->motorista){
            $error[] = 'Selecione um motorista';
        }
        if(!$request->carro){
            $error[] = 'Selecione um carro!';
        }
        if(!$request->horario){
            $error[] = 'Insira um horário!';
        }
        if(!$request->hasFile('fotos')){
            $error[] =  'Insira pelo menos um arquivo!';
        }
        else{
            foreach($request->file('fotos') as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                //dd($check);
                if(!$check){
                    $error[] =  'Insira somente arquivos válidos! As extensões aceitas são jpg, png e gif.';
                }
            }
        }
        if(isset($error)){
            return redirect()->back()->with('error', $error);
        }
        $entrada->motorista_id = $request->motorista;
        $entrada->carro_id = $request->carro;
        $entrada->horario = $request->horario;
        $entrada->save();
        $this->validate($request, [
            'fotos' => 'required'
        ]);
        if($request->hasFile('fotos')){
            $files = $request->file('fotos');
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                //dd($check);
                if($check){
                    $filename = $file->store('fotos');
                    Foto::create([
                        'entrada_id' => $entrada->id,
                        'path' => $filename
                    ]);
                    
                    //echo "Upload Successfully";
                }
                /*else{
                    echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                }*/
            }
        }
        return redirect()->back()->with('message', 'Sucesso ao cadastrar entrada!');
    }

    public function create(){
        $Motorista = Motorista::all();
        $motorista = $Motorista->where('ativo', 1);
        $Carro = Carro::all();
        $carro = $Carro->where('ativo', 1);
        return view('entrada.create', compact('motorista', 'carro'));
    }

    public function show($id){
        return Entrada::find($id);
    }
}
/* https://www.cloudways.com/blog/laravel-multiple-files-images-upload/ base do upload. antes tava adicionando o nome via script, mas pegava o fakepath e não fazia upload de fato. depois fazia upload mas só de um arquivo. */