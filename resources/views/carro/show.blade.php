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
                    <a class="list-group-item list-group-item-action" href="{{ url('/carro/listar/'.$carro->id) }}">{{ $carro->nome }} - {{ $carro->placa }}</a>
                    @endforeach

                </div>
            </div>
            <div id="formFooter">
            </div>
        
    

    </div>
</div>
 @endsection