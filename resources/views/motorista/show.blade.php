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
                    <li class="list-group-item list-group-item-action"><div class="d-flex"> <div class="mr-auto p-2"> {{ $motorista->nome }} - {{ $motorista->cpf }} </div><div class="p-2 iconesLista"><a href="{{ url('/motorista/listar/excluir/'.$motorista->id) }}">  <i class="fas fa-trash"></i> </a> <a href="{{ url('/motorista/listar/'.$motorista->id) }}"> <i class="fas fa-edit"></i></a></div></li>
                    @endforeach

                </div>
            </div>
            <div id="formFooter">
                <div class="d-flex justify-content-center">
                {{ $motoristas->links() }}
                </div>
            </div>
        
    

    </div>
</div>
 @endsection