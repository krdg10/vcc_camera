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
                    <a class="list-group-item list-group-item-action" href="{{ url('/motorista/listar/'.$motorista->id) }}">{{ $motorista->nome }} - {{ $motorista->cpf }}</a>
                    @endforeach

                </div>
            </div>
            <div id="formFooter">
            </div>
        
    

    </div>
</div>
 @endsection