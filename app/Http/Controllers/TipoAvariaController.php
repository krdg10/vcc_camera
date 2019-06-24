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
        //
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
