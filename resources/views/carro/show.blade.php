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
                    <li class="list-group-item list-group-item-action"><div class="d-flex"> <div class="mr-auto p-2"> {{ $carro->nome }} - {{ $carro->placa }} </div><div class="p-2 iconesLista"><a href="{{ url('/carro/listar/excluir/'.$carro->id) }}"> <i class="fas fa-trash"></i> </a> <a href="{{ url('/carro/listar/'.$carro->id) }}"> <i class="fas fa-edit"></i></a></div></li>
                    @endforeach

                </div>
            </div>
            <div id="formFooter">
                <div class="d-flex justify-content-center">
                {{ $carros->links() }}
                </div>
            </div>
        
    

    </div>
</div>
 @endsection