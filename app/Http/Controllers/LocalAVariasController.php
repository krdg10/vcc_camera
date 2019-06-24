<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local_avaria;

class LocalAVariasController extends Controller{
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
        return Local_avaria::all();
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
