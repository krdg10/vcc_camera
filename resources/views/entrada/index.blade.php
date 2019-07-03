@extends('layouts.app')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">
            <h3>Lista de Entradas</h3>
            <a data-toggle="modal" href="#modalBusca" data-target="#modalBusca"><i class="fas fa-search">Buscar</i></a>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Motorista</th>
                        <th>Carro</th>
                        <th>Horário</th>
                        <th>Verificar</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($entradas)==0)
                        <h3>Nenhuma Entrada Encontrada</h3>
                    @else
                    @foreach ($entradas as $entrada)
                        <tr>
                            <td>{{$entrada->id}}</td>
                            <td>{{$entrada->motorista->nome}}</td>
                            <td>{{$entrada->carro->nome}}</td>
                            <td>{{$entrada->horario}}</td>
                            <td>
                                @forelse  ($entrada->verificacoes as $verificacao)
                                    <a href="/verificacao/edit/{{$verificacao->id}}" class="iconesLista"><i class="fas fa-edit"></i></a>
                                    <a href="/verificacao/exibir/{{$verificacao->id}}" class="iconesLista"><i class="fas fa-eye"></i></a>
                                @empty
                                    <a href="/verificacao/{{$entrada->id}}" class="iconesLista"><i class="fas fa-plus-circle"></i></a>
                                @endforelse
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div id="formFooter">
            <div class="d-flex justify-content-center">
                {{ $entradas->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBusca" tabindex="-1" role="dialog" aria-labelledby="busca" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="formConten">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar Entrada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="fadeIn first">
                <form method="POST" action="{{route('entrada.busca')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="nome" id="nome" placeholder="Nome do Motorista" class="form-control">
                    <input type="text" name="carro" id="carro" placeholder="Nome do Carro" class="form-control">
                    <input type="datetime-local" name="horario" id="horario" placeholder="Horário" class="form-control">
                    <label>Buscar Apenas Já Verificados: </label><input type="checkbox" name="verificado" id="verificado" placeholder="Verificado" class="form-control" value="1">
                    
                    <div id="formFooter">
                        <button type="submit" id="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
