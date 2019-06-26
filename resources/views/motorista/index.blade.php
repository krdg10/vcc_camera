@extends('layouts.app')
@section('content')
<script>
    function valida() {
        var cpf = document.getElementsByName('cpf')[0].value;
        var codigo_empresa = document.getElementsByName('codigo_empresa')[0].value;
        var codigo_transdata = document.getElementsByName('codigo_transdata')[0].value;
        
        var valida = /^\d+$/;
       
        if (valida.test(cpf)==true && valida.test(codigo_empresa)==true && valida.test(codigo_transdata)==true ) {
            return true;
        } 
        else if (valida.test(cpf)==false){
            alert("Verifique o CPF. Apenas números são permitidos!");
        }
        else if (valida.test(codigo_empresa)==false){
            alert("Verifique o código da empresa. Apenas números são permitidos!");
        }
        else if (valida.test(codigo_transdata)==false){
            alert("Verifique o código transdata. Apenas números são permitidos!");
        }
        else {
            return false;
        }
    }
    function excluirElement(id){
        $('#'+id).remove();
    }
</script>
<!-- script valida verifica se há apenas números positivos em cpf, codigo da empresa e codigo vcc. Alerta de tamanho não precisa script pois minlenght já faz isso -->

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Motorista</h3> 
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
        <form method="POST" action="{{ route('motorista.store') }}" enctype="multipart/form-data" onsubmit="return valida();">
        {{ csrf_field() }}
            <input type="text" placeholder="Nome" name="nome" class="form-control">
            <input type="text" placeholder="CPF" name="cpf" class="form-control" maxlength="11" minlength="11">
            <input type="date" placeholder="Data de Nascimento" name="data_nascimento" class="form-control">
            <input type="text" placeholder="Código VCC" name="codigo_empresa" class="form-control" maxlength="4" minlength="4">
            <input type="text" placeholder="Código Transdata" name="codigo_transdata" class="form-control" maxlength="5" minlength="5">
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>

        </form>
    </div>
</div>
@endsection
