@extends('layouts.app')
@section('content')

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Editar Carro</h3> <hr>
        <form method="POST" action="{{ route('carro.update', $Carro->id) }}" enctype="multipart/form-data" >
        {{ csrf_field() }}
            <input type="text" placeholder="Nome" name="nome" class="form-control" value="{{ $Carro->nome }}">
            <input type="text" placeholder="Placa" name="placa" class="form-control" maxlength="7" minlength="7" value="{{ $Carro->placa }}">
            <input type="text" placeholder="Modelo" name="modelo" class="form-control" value="{{ $Carro->modelo }}">
            <input type="text" placeholder="Ano" name="ano" class="form-control" maxlength="4" minlength="4" value="{{ $Carro->ano }}">
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Atualizar </button>
            </div>

        </form>
    </div>
</div>

@endsection
