<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entrada;
use App\Models\Carro;
use App\Models\Motorista;
use App\Models\Foto;

class EntradaController extends Controller{
    public function index(){
        $motorista = new Motorista;
        $carro = new Carro;
        $motorista = Motorista::all();
        $carro = Carro::all();
        return view('entrada.index', compact('motorista', 'carro'));
    }
    
    public function store(Request $request){
        $entrada = new Entrada;
        if(!$entrada->nome){
            $error[] = 'Coloque algum nome para seu motorista!';
        }

        $entrada->motorista_id = $request->motorista;
        $entrada->carro_id = $request->carro;
        $entrada->horario = $request->horario;
        $entrada->save();
       
            
            $this->validate($request, [
                'fotos' => 'required'
             ]);
             if($request->hasFile('fotos'))
              {
                $allowedfileExtension=['pdf','jpg','png','docx'];
                $files = $request->file('fotos');
                foreach($files as $file){
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check=in_array($extension,$allowedfileExtension);
                    //dd($check);
                    if($check)
                    {
                        
                       
                            $filename = $file->store('fotos');
                            Foto::create([
                                'entrada_id' => $entrada->id,
                                'path' => $filename
                            ]);
                    
                        echo "Upload Successfully";
                    }
                    else
                    {
                        echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                    }
                }
             }
           
            
        
        
        return redirect()->back()->with('message', 'Sucesso ao cadastrar entrada!');
    }
}
/* https://www.cloudways.com/blog/laravel-multiple-files-images-upload/ base do upload. antes tava adicionando o nome via script, mas pegava o fakepath e não fazia upload de fato. depois fazia upload mas só de um arquivo. */