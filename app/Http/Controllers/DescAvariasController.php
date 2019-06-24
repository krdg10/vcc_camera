<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Desc_avaria;

class DescAvariasController extends Controller{
    public function index(){
    }

    public function create(){
        //
    }

    public function store(Request $request){
        //
    }

    public function show($id=""){
        return Desc_avaria::all();
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
