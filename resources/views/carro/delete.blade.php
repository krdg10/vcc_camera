@extends('layouts.app')
@section('content')

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Deletar Carro</h3> <hr>
        <form method="POST" action="{{ route('carro.destroy', $Carro->id) }}" enctype="multipart/form-data" >
        
            <input type="text" placeholder="Nome" name="nome" class="form-control" value="{{ $Carro->nome }}" disabled>
            <input type="text" placeholder="Placa" name="placa" class="form-control" maxlength="7" minlength="7" value="{{ $Carro->placa }}" disabled>
            <input type="text" placeholder="Modelo" name="modelo" class="form-control" value="{{ $Carro->modelo }}" disabled>
            <input type="text" placeholder="Ano" name="ano" class="form-control" maxlength="4" minlength="4" value="{{ $Carro->ano }}" disabled>
            <input type="text" placeholder="RFID" name="rfid" class="form-control" value="{{ $Carro->rfid }}" disabled>
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary" value="delete"> Excluir </button>
                @method('delete')
                @csrf
            </div>

        </form>
    </div>
</div>

@endsection
