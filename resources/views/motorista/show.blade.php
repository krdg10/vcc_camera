@extends('layouts.app')
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">
            <h3>Lista de Motoristas </h3>
            <a data-toggle="modal" href="#modalBusca" data-target="#modalBusca"><i class="fas fa-search">Buscar</i></a>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Código VCC</th>
                        <th>Código Transdata</th>
                        <th>Apagar/
                        Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($motoristas)==0)
                        <h3>Nenhum Motorista Encontrado</h3>
                    @endif
                    @foreach ($motoristas as $motorista)
                        <tr>
                            <td>{{$motorista->nome}}</td>
                            <td>{{$motorista->cpf}}</td>
                            <td>{{$motorista->codigo_empresa}}</td>
                            <td>{{$motorista->codigo_transdata}}</td>
                            <td><div class="p-2 iconesLista"><a href="{{ url('/motorista/listar/excluir/'.$motorista->id) }}">  <i class="fas fa-trash"></i> </a> <a href="{{ url('/motorista/listar/'.$motorista->id) }}"> <i class="fas fa-edit"></i></a></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>   
            <div id="formFooter">
                <div class="d-flex justify-content-center">
                {{ $motoristas->links() }}
                </div>
            </div>
    
        </div>
    </div>
</div>
<div class="modal fade" id="modalBusca" tabindex="-1" role="dialog" aria-labelledby="busca" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="formConten">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar Motorista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="fadeIn first">
                <form method="POST" action="{{route('motorista.busca')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control">
                    <input type="text" name="cpf" id="cpf" placeholder="CPF" class="form-control">
                    <input type="text" name="codigo_empresa" id="codigo_empresa" placeholder="Código VCC" class="form-control">
                    <input type="text" name="codigo_transdata" id="codigo_transdata" placeholder="Código Transdata" class="form-control">

                    <div id="formFooter">
                        <button type="submit" id="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 @endsection