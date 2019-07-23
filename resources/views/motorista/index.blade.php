@extends('layouts.app')
@section('content')
<script>
    var metodos;
    window.onload = function(){
            metodos = new Metodos('metodos', '{{csrf_token()}}');

        @if( \Session::has('error') )
            @foreach(session()->get('error') as $key => $ms)
                metodos.msgError('{{ $ms }}', 'divMsg');
            @endforeach
        @endif
        @if( Session::has('message') )
            metodos.msgSuccess('{{ \Session::get('message') }}', 'divMsg');
        @endif
    }

    // script valida verifica se há apenas números positivos em cpf, codigo da empresa e codigo vcc. 
    // Alerta de tamanho não precisa script pois minlenght já faz isso
    function valida() {
        var cpf = document.getElementsByName('cpf')[0].value;
        var codigo_empresa = document.getElementsByName('codigo_empresa')[0].value;
        var codigo_transdata = document.getElementsByName('codigo_transdata')[0].value;
        
        var valida = /^\d+$/;

        if (valida.test(cpf) == false){
            metodos.msgError("Verifique o CPF. Apenas números são permitidos!", 'divMsg');
            return false;
        }

        else if (valida.test(codigo_empresa) == false){
            metodos.msgError("Verifique o código da empresa. Apenas números são permitidos!", 'divMsg');
            return false;
        }

        else if (valida.test(codigo_transdata) == false){
            metodos.msgError("Verifique o código transdata. Apenas números são permitidos!", 'divMsg');
            return false;
        }

        return true;
    }
</script>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Motorista</h3> 
        
        {{-- DIV PARA EXIBIR MENSAGENS --}}
        <div id="divMsg"></div>

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
