@extends('layouts.app')
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
        <h3>Lista de Motoristas </h3>
        </div>
            <hr>
            <div class="container">
                <div class="list-group">
                    @foreach ($motoristas as $motorista) 
                    <li class="list-group-item list-group-item-action">{{ $motorista->nome }} - {{ $motorista->cpf }} <div class="iconesLista"><a href="{{ url('/motorista/listar/excluir/'.$motorista->id) }}">  <i class="fa fa-trash" aria-hidden="true"></i> </a> <a href="{{ url('/motorista/listar/'.$motorista->id) }}"> <i class="fa fa-pencil" aria-hidden="true"></i></a></div></li>
                    @endforeach

                </div>
            </div>
            <div id="formFooter">
            </div>
        
    

    </div>
</div>
 @endsection