<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entrada;
use App\Models\Carro;
use App\Models\Motorista;
use App\Models\Foto;
use App\Models\Verificacao;
use Illuminate\Support\Facades\DB;


class EntradaController extends Controller{
    public function index(){
        $entradas = Entrada::orderBy('horario', 'desc')->paginate(5);
        return view('entrada.index', compact('entradas'));
    }
    public function busca(Request $request){
        if($request->verificado==1){
            $query = DB::table('entradas')
                ->join('motoristas', 'motoristas.id', '=', 'entradas.motorista_id')
                ->join('carros', 'carros.id', '=', 'entradas.carro_id')
                ->join('verificacoes', 'verificacoes.entrada_id', '=', 'entradas.id')
                ->where('entradas.horario', $request->horario)->orWhere('motoristas.nome', $request->nome)->orWhere('carros.nome', $request->carro)
                ->orderBy('entradas.horario', 'desc')
                ->get('entradas.id');
        }
        else{
            $query = DB::table('entradas')
                ->join('motoristas', 'motoristas.id', '=', 'entradas.motorista_id')
                ->join('carros', 'carros.id', '=', 'entradas.carro_id')
                ->where('entradas.horario', $request->horario)->orWhere('motoristas.nome', $request->nome)->orWhere('carros.nome', $request->carro)
                ->orderBy('entradas.horario', 'desc')
                ->get('entradas.id');
        }
        //select `entradas`.`id` from `entradas` inner join `motoristas` on `motoristas`.`id` = `entradas`.`motorista_id` inner join `carros` on `carros`.`id` = `entradas`.`carro_id` inner join `verificacoes` on `verificacoes`.`entrada_id` = `entradas`.`id` where `entradas`.`horario` = '2019-07-01 15:15:00' or `motoristas`.`nome` is null or `carros`.`nome` is null
        //quando select * ou get() tava dando ruim.
        //esse código não tinha o orderBy
        //error_log($query);
        foreach($query as $entrada){
            $entradas[]= Entrada::find($entrada->id);
        }


        //deixei um count na view como verificação. Podia mandar mensagem, mas ia ter que colocar todo aquele código lá. 
        //O problema: quando abrir view, se não tiver nada cadastrado, vai aparecer a mensagem como se fosse busca
        return view('entrada.index', compact('entradas'));
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