<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entrada;
use App\Models\Carro;
use App\Models\Motorista;
use App\Models\Foto;
use App\Models\Verificacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EntradaController extends Controller{
    public function listaEntradas(){
        $entradas = Entrada::orderBy('horario', 'desc')->paginate(5);
        return view('entrada.listaEntradas', compact('entradas'));
    }
    
    public function buscaEntradas(Request $request){
        EntradaController::verifyIfSearchIsEmpty($request);

        $nome = $request->nome;
        $horario = $request->horario;
        $carro = $request->carro;
        $entradas = EntradaController::getSearchResults($request);
        
        return view('entrada.busca', ['entradas' => $entradas, 'nome' => $request->nome, 
        'horario' => $request->horario, 'carro' => $request->carro, 'verificado' => $request->verificado, 'n_verificado' => $request->n_verificado]);
    }

    public function storeEntradas(Request $request){
        $validator = Validator::make($request->all(), EntradaController::rulesEntrada());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
           
        $entrada = new Entrada;
        $combinatedBeginDateAndTime = EntradaController::combineDateAndTimeInUniqueVariable($request->data, $request->horario);

        $entrada->motorista_id = $request->motorista;
        $entrada->carro_id = $request->carro;
        $entrada->horario = $combinatedBeginDateAndTime;
        $entrada->save();
        
        $files = $request->file('fotos');
        foreach($files as $file){
            $filename = $file->store('fotos');
            Foto::create([
                'entrada_id' => $entrada->id,
                'path' => $filename
            ]);
        }
    
        return redirect()->back()->with('message', 'Sucesso ao cadastrar entrada!');
    }

    public function storeEntradasByRFID($rfid){
        try {
            $entrada = new Entrada;
            $veiculos = Carro::where('rfid', '=', $rfid)->get();

            if($veiculos->count() == 0)
                return Metodos::retornoJson(0, 'Não foi encontrado o veiculo associado ao rfid: '. $rfid);

            $entrada->carro_id = $veiculos[0]->id;

            $entrada->horario = date('Y-m-d H:i:s');

            $entrada->save();

            copy('http://admin:vcc123456@192.168.1.64:64/Streaming/channels/1/picture','C:\Users\Administrativo\vcc_cam\storage\app\public\fotos\1_store_rbt_'. $entrada->id .'.jpg');

            //copy('http://admin:vcc123456@192.168.1.65:64/Streaming/channels/2/picture','C:\Users\Administrativo\vcc_cam\storage\app\public\fotos\2_store_rbt_'. $entrada->id .'.jpg');
            
            Foto::create([
                'entrada_id' => $entrada->id,
                'path' => 'fotos/1_store_rbt_'. $entrada->id .'.jpg'
            ]);

            /*Foto::create([
                'entrada_id' => $entrada->id,
                'path' => 'fotos/2_store_rbt_'. $entrada->id .'.jpg'
            ]);*/
            
            return Metodos::retornoJson(1, 'Entrada salva com sucesso.');
        } catch (Exception $e) {
            return Metodos::retornoJson(0, 'Ocorreu um erro ao salvar a imagem.', $e);
        }
    }
    
    public function createEntrada(){
        $motorista = EntradaController::getAllActiveDrivers();
        $carro = Carro::where('ativo', 1)->get();

        return view('entrada.create', compact('motorista', 'carro'));
    }

    public function exibeEntrada($id){
        $entrada = Entrada::findOrFail($id);
        EntradaController::verifyIfDriverExists($entrada->motorista);
        
        $fotos = $entrada->fotos;

        $motorista = EntradaController::getAllActiveDrivers();
        return view('entrada.addMotorista', compact('motorista', 'entrada', 'fotos'));
    }

    public function adicionaMotoristaEntrada(Request $request, $id){
        EntradaController::verifyIfDriveHasAddicted($request->motorista);
        $entrada = Entrada::findOrFail($id);
        $entrada->motorista_id = $request->motorista;
        
        $entrada->save();
        
        return redirect('/entrada')->with('message', 'Sucesso ao adicionar a Motorista!');//tava dando errado pq era redirect back. ai voltava pra pagina exibe com motorista adicionado. Ai direcionada pra lista com msg de ja existente
    }

    public function combineDateAndTimeInUniqueVariable($date, $hour){
        return date('Y-m-d H:i:s', strtotime("$date $hour"));
    }

    public function verifyIfDriveHasAddicted($motorista){
        if($motorista=='false'){
            return redirect('/entrada')->with('error', 'Nenhum motorista foi adicionado!');
        }
        return;
    }
    
    public function verifyIfDriverExists($motorista){
        if ($motorista){
            return redirect('/entrada')->with('error', 'Motorista já cadastrado!');
        }
        return;
    }

    public function getAllActiveDrivers(){
        return Motorista::where('ativo', 1)->get();
    }

    public function verifyIfSearchIsEmpty($request){
        if($request->nome == null && $request->carro == null && $request->horario == null && $request->verificado == null && $request->n_verificado == null){
            $entradas = Entrada::orderBy('horario', 'desc')->paginate(5);
            return view('entrada.listaEntradas', compact('entradas'));
        }
        return;
    }

    public function getSearchResults($request){
        return Entrada::join('motoristas', 'motoristas.id', '=', 'entradas.motorista_id')
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
    }

    public function rulesEntrada(){
        return [
            'carro' => 'required|numeric',
            'data' => 'required|date',
            'horario' => 'required|date_format:H:i',
            'fotos' => 'required',
            'fotos.*' => 'image',
            'motorista' => 'required|numeric'
        ];
    }
}
/* https://www.cloudways.com/blog/laravel-multiple-files-images-upload/ base do upload. antes tava adicionando o nome via script, mas pegava o fakepath e não fazia upload de fato. depois fazia upload mas só de um arquivo. */