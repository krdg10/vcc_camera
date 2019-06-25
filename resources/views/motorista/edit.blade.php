@extends('layouts.app')
@section('content')

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Editar Motorista</h3> <hr>
        <form method="POST" action="{{ route('motorista.update', $Motorista->id) }}" enctype="multipart/form-data" >
        {{ csrf_field() }}
            <input type="text" placeholder="Nome" name="nome" class="form-control" value="{{ $Motorista->nome }}">
            <input type="text" placeholder="CPF" name="cpf" class="form-control" maxlength="11" minlength="11" value="{{ $Motorista->cpf }}">
            <input type="text" placeholder="Data de Nascimento" name="data_nascimento" class="form-control" value="{{ $Motorista->data_nascimento }}">
            <input type="text" placeholder="Código VCC" name="codigo_empresa" class="form-control" maxlength="4" minlength="4" value="{{ $Motorista->codigo_empresa }}">
            <input type="text" placeholder="Código Transdata" name="codigo_transdata" class="form-control" maxlength="5" minlength="5" value="{{ $Motorista->codigo_transdata }}">
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>

        </form>
    </div>
</div>

@endsection
