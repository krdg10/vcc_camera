@extends('layouts.app')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <table class="table table-hover ">
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
                @foreach ($entradas as $entrada)
                    <tr>
                        <td>{{$entrada->id}}</td>
                        <td>{{$entrada->motorista->nome}}</td>
                        <td>{{$entrada->carro->nome}}</td>
                        <td>{{$entrada->horario}}</td>
                        <td>
                            <a href="/verificacao/{{$entrada->id}}" class="iconesLista"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
