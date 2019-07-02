<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entrada;
use App\Models\Carro;
use App\Models\Motorista;
use App\Models\Foto;
use App\Models\Verificacao;


class EntradaController extends Controller{
    public function index(){
        $entradas = Entrada::paginate(5);
        $verificacoes = Verificacao::all();
        return view('entrada.index', compact('entradas', 'verificacoes'));
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
        $motorista = Motorista::all();
        $carro = Carro::all();
        return view('entrada.create', compact('motorista', 'carro'));
    }

    public function show($id){
        return Entrada::find($id);
    }
}
/* https://www.cloudways.com/blog/laravel-multiple-files-images-upload/ base do upload. antes tava adicionando o nome via script, mas pegava o fakepath e não fazia upload de fato. depois fazia upload mas só de um arquivo. */