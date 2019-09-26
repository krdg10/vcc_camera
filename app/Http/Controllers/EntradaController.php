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

        $nome = $request->nome;
        $horario = $request->horario;
        $carro = $request->carro; //talvez n precisa pq o parametro do when pega o request do when. mas...
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
        //https://stackoverflow.com/questions/28176292/laravel-query-builder-returns-object-or-array
        return view('entrada.busca', ['entradas' => $entradas, 'nome' => $request->nome, 
        'horario' => $request->horario, 'carro' => $request->carro, 'verificado' => $request->verificado, 'n_verificado' => $request->n_verificado]);
    }

    public function store(Request $request){
        $entrada = new Entrada;
        $allowedfileExtension=['jpg','png','gif'];

        if($request->carro=='false')
            $error[] = 'Selecione um carro!';
        
        if(!$request->horario)
            $error[] = 'Insira um horário!';

        if(!$request->hasFile('fotos'))
            $error[] =  'Insira pelo menos um arquivo!';
        
        else{
            foreach($request->file('fotos') as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                if(!$check){
                    $error[] = 'Insira somente arquivos válidos! As extensões aceitas são jpg, png e gif.';
                }
            }
        }
        if(isset($error))
            return redirect()->back()->with('error', $error);
        
        if(!$request->motorista)
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

                if($check){
                    $filename = $file->store('fotos');
                    Foto::create([
                        'entrada_id' => $entrada->id,
                        'path' => $filename
                    ]);
                }
            }
        }
        return redirect()->back()->with('message', 'Sucesso ao cadastrar entrada!');
    }

    public function storeRbt($rfid){
        try {
            $entrada = new Entrada;
            $veiculos = Carro::where('rfid', '=', $rfid)->get();

            if($veiculos->count() == 0)
                return Metodos::retornoJson(0, 'Não foi encontrado o veiculo associado ao rfid: '. $rfid);

            $entrada->carro_id = $veiculos[0]->id;

            $entrada->horario = date('Y-m-d H:i:s');

            $entrada->save();

            copy('http://admin:vcc123456@192.168.1.64:64/Streaming/channels/1/picture','C:\Users\Administrativo\vcc_cam\storage\app\public\fotos\1_store_rbt_'. $entrada->id .'.jpg');

            copy('http://admin:vcc123456@192.168.1.65:64/Streaming/channels/2/picture','C:\Users\Administrativo\vcc_cam\storage\app\public\fotos\2_store_rbt_'. $entrada->id .'.jpg');
            
            Foto::create([
                'entrada_id' => $entrada->id,
                'path' => 'fotos/1_store_rbt_'. $entrada->id .'.jpg'
            ]);

            Foto::create([
                'entrada_id' => $entrada->id,
                'path' => 'fotos/2_store_rbt_'. $entrada->id .'.jpg'
            ]);
            
            return Metodos::retornoJson(1, 'Entrada salva com sucesso.');
        } catch (Exception $e) {
            return Metodos::retornoJson(0, 'Ocorreu um erro ao salvar a imagem.', $e);
        }
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

    public function exibe($id){
        $entrada = Entrada::find($id);
        // VERIFICA SE JÁ HÁ MOTORISTA
        // funcionando, mas entra aqui de qualquer jeito. dai manda a msg errada.
        
        if ($entrada->motorista){
            $error[] = 'Motorista já cadastrado!';
            return redirect('/entrada')->with('error', $error);
        }
        $entradaController = new EntradaController;

        $fotos = $entradaController->show($entrada->id)->fotos;//tinha apagado o show e isso dava ruim

        $Motorista = Motorista::all();
        $motorista = $Motorista->where('ativo', 1);
        return view('entrada.addMotorista', compact('motorista', 'entrada', 'fotos'));
    }

    public function adicionaMotorista(Request $request, $id){
        if($request->motorista=='false'){//era só por o false como string vsfff
            $error[] = 'Nenhum motorista foi adicionado!'; //tava dando BO pq error tem que ser array. message n precisa. Redirect back volta pra msm page.
            return redirect('/entrada')->with('error', $error);
        }
        $entrada = Entrada::findOrFail($id);;
        $entrada->motorista_id = $request->motorista;
        
        $entrada->save();
        
        return redirect('/entrada')->with('message', 'Sucesso ao adicionar a Motorista!');//tava dando errado pq era redirect back. ai voltava pra pagina exibe com motorista adicionado. Ai direcionada pra lista com msg de ja existente
    }
}
/* https://www.cloudways.com/blog/laravel-multiple-files-images-upload/ base do upload. antes tava adicionando o nome via script, mas pegava o fakepath e não fazia upload de fato. depois fazia upload mas só de um arquivo. */