@extends('layouts.app')
@section('content')
<script>
    
    function valida() {
        var cpf = document.getElementsByName('cpf')[0].value;
        var codigo_empresa = document.getElementsByName('codigo_empresa')[0].value;
        var codigo_transdata = document.getElementsByName('codigo_transdata')[0].value;
        var nascimento = document.getElementsByName('data_nascimento')[0].value;
        var validaNascimento = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;
        var valida = /^\d+$/;
       
        if (valida.test(cpf)==true && valida.test(codigo_empresa)==true && valida.test(codigo_transdata)==true && validaNascimento.test(nascimento)==true) {
            return true;
        }
        else if (valida.test(cpf)==false){
            alert("Verifique o CPF. Apenas números são permitidos!");
        }
        else if (validaNascimento.test(nascimento)==false){
            alert("Verifique a data. Apenas números são permitidos! O formato é AAAA-MM-DD HH-MM-SS.");
            return false;
        }
        else if (valida.test(codigo_empresa)==false){
            alert("Verifique o código da empresa. Apenas números são permitidos!");
        }
        else if (valida.test(codigo_transdata)==false){
            alert("Verifique o código da Transdata. Apenas números são permitidos!");
        }
        else {
            return false;
        }
    }
    function excluirElement(id){
        $('#'+id).remove();
    }
</script>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Editar Motorista</h3> 
        {{-- Exibe mensagem de sucesso ou de erro caso haja. --}}
        @if( \Session::has('error') )
            @foreach(session()->get('error') as $key => $ms)
                <span id="{{ $key }}error" class="badge badge-danger badge-pill">
                    {{ $ms }}
                    <a id="excluir" onClick="excluirElement('{{ $key }}error')"><i class="fa fa-times" aria-hidden="true"></i></a>
                </span>
            @endforeach
        @endif
        @if( \Session::has('message') )
            <span id="success" class="badge badge-success badge-pill">
                {{ \Session::get('message') }}
                    <a id="excluir" onClick="excluirElement('success')"><i class="fa fa-times" aria-hidden="true"></i></a>
            </span>
        @endif
        <hr>
        <form method="POST" action="{{ route('motorista.update', $Motorista->id) }}" enctype="multipart/form-data" onsubmit="return valida();"> <!-- forma de validar data aqui é o regex. is date é só sqlserver, o hasdate n peguei funcionamento -->
        {{ csrf_field() }}
            <input type="text" placeholder="Nome" name="nome" class="form-control" value="{{ $Motorista->nome }}">
            <input type="text" placeholder="CPF" name="cpf" class="form-control" maxlength="11" minlength="11" value="{{ $Motorista->cpf }}">
            <input type="text" placeholder="Data de Nascimento" name="data_nascimento" class="form-control" value="{{ $Motorista->data_nascimento }}" maxlength="19">
            <input type="text" placeholder="Código VCC" name="codigo_empresa" class="form-control" maxlength="4" minlength="4" value="{{ $Motorista->codigo_empresa }}">
            <input type="text" placeholder="Código Transdata" name="codigo_transdata" class="form-control" maxlength="5" minlength="5" value="{{ $Motorista->codigo_transdata }}">
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>

        </form>
    </div>
</div>

@endsection
