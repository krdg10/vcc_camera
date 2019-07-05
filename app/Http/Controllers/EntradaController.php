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
        if($request->nome == null && $request->carro == null && $request->horario == null){
            $entradas = Entrada::orderBy('horario', 'desc')->paginate(5);
            return view('entrada.index', compact('entradas'));
        }
        //tinha um join do laravel com os or. Qualquer coisa tá no git. 
        
        $pesquisa="select `entradas`.`id` from `entradas` inner join `motoristas` on `motoristas`.`id` = `entradas`.`motorista_id` inner join `carros` on `carros`.`id` = `entradas`.`carro_id`";
        $primeiro=0;
        if($request->verificado==1){
            $pesquisa = $pesquisa . ' ' . "inner join `verificacoes` on `verificacoes`.`entrada_id` = `entradas`.`id`";
        }
        if($request->nome != null){
            if ($primeiro==0){
                $pesquisa = $pesquisa . ' ' . "where `motoristas`.`nome` LIKE '%$request->nome%'";
                $primeiro=1;
            }
        }
        if($request->carro != null){
            if ($primeiro==0){
                $pesquisa = $pesquisa . ' ' . "where `carros`.`nome` LIKE '%$request->carro%'";
                $primeiro=1;
            }
            else {
                $pesquisa = $pesquisa . ' ' . "and `carros`.`nome` LIKE '%$request->carro%'";
            }
        }
        if ($request->horario != null){
            if ($primeiro==0){
                $pesquisa = $pesquisa . ' ' . "where `entradas`.`horario` = '$request->horario'";
                $primeiro=1;
            }
            else {
                $pesquisa = $pesquisa . ' ' . "and `entradas`.`horario` = '$request->horario'";
            }
        }
        $pesquisa = $pesquisa . ' ' . "order by `entradas`.`horario` desc";
        //error_log($pesquisa);

        $query=DB::select(DB::raw($pesquisa));
    
        //https://medium.com/justlaravel/paginated-data-with-search-functionality-in-laravel-ee0b1668b687
        //select `entradas`.`id` from `entradas` inner join `motoristas` on `motoristas`.`id` = `entradas`.`motorista_id` inner join `carros` on `carros`.`id` = `entradas`.`carro_id` inner join `verificacoes` on `verificacoes`.`entrada_id` = `entradas`.`id` where `entradas`.`horario` = '2019-07-01 15:15:00' or `motoristas`.`nome` is null or `carros`.`nome` is null
        //quando select * ou get() tava dando ruim.
        //esse código não tinha o orderBy
        //error_log($query);
        $temp = null;
        foreach($query as $entrada){
            $temp[]= Entrada::find($entrada->id);
        }
        /*if(isset($teste)==0){
            $entradas = Entrada::orderBy('horario', 'desc')->paginate(5);
            return view('entrada.busca', compact('entradas'));
        }*/
        //funcionando sem dar outro return pra caso teste null. Melhor assim ate pq n saberia o que
        //voltar caso fosse null msm
       // Get current page form url e.x. &page=1
       $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
       // Create a new Laravel collection from the array data
       $itemCollection = collect($temp);

       // Define how many items we want to be visible in each page
       $perPage = 5;

       // Slice the collection to get the items to display in current page
       $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

       // Create our paginator and pass it to the view
       $entradas= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

       // set url path for generted links
       $entradas->setPath($request->url());
   
        
     


        //deixei um count na view como verificação. Podia mandar mensagem, mas ia ter que colocar todo aquele código lá. 
        //O problema: quando abrir view, se não tiver nada cadastrado, vai aparecer a mensagem como se fosse busca
        return view('entrada.busca', ['entradas' => $entradas, 'nome' => $request->nome, 
        'horario' => $request->horario, 'carro' => $request->carro, 'verificado' => $request->verificado]);
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