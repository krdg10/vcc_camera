@extends('layouts.app')
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
        <h3>Lista de Carros </h3>
        </div>
            <hr>
            <div class="container">
                <div class="list-group">
                    @foreach ($carros as $carro) 
                    <li class="list-group-item list-group-item-action"><div class="textoLista"> {{ $carro->nome }} - {{ $carro->placa }} </div><div class="iconesLista"><a href="{{ url('/carro/listar/excluir/'.$carro->id) }}"> <i class="fa fa-trash" aria-hidden="true"></i> </a> <a href="{{ url('/carro/listar/'.$carro->id) }}"> <i class="fa fa-pencil" aria-hidden="true"></i></a></div></li>
                    @endforeach

                </div>
            </div>
            <div id="formFooter">
            </div>
        
    

    </div>
</div>
 @endsection