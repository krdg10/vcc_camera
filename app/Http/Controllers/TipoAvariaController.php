<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo_avarias;

class TipoAvariaController extends Controller{
    public function index(){
        //
    }

    public function create(){
        //
    }

    public function store(Request $request){
        try {
            $tipo_avarias = new Tipo_avarias;
            $tipo_avarias->tipo = $request->data->tipo;
            $tipo_avarias->save();
        } catch (Exception $e) {
            
        }
    }

    public function show($id=""){
        return Tipo_avarias::all();
    }

    public function edit($id){
        //
    }

    public function update(Request $request, $id){
        //
    }

    public function destroy($id){
        //
    }
}
