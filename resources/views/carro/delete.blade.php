@extends('layouts.app')
@section('content')

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Deletar Carro</h3> <hr>
        <form method="POST" action="{{ route('carro.destroy', $Carro->id) }}" enctype="multipart/form-data" >
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" placeholder="Nome" name="nome" class="form-control" value="{{ $Carro->nome }}" disabled>
            </div>
            <div class="form-group">
                <label for="placa">Placa</label>
                <input type="text" placeholder="Placa" name="placa" class="form-control" maxlength="7" minlength="7" value="{{ $Carro->placa }}" disabled>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" placeholder="Modelo" name="modelo" class="form-control" value="{{ $Carro->modelo }}" disabled>
            </div>
            <div class="form-group">
                <label for="ano">Ano</label>
                <input type="text" placeholder="Ano" name="ano" class="form-control" maxlength="4" minlength="4" value="{{ $Carro->ano }}" disabled>
            </div>
            <div class="form-group">
                <label for="rfid">RFID</label>
                <input type="text" placeholder="RFID" name="rfid" class="form-control" value="{{ $Carro->rfid }}" disabled>
            </div>
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary" value="delete"> Excluir </button>
                @method('delete')
                @csrf
            </div>

        </form>
    </div>
</div>

@endsection
