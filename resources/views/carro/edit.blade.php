@extends('layouts.app')
@section('content')
<script>
    function validaCampos() {
        var ano = document.getElementsByName('ano')[0].value;
        var placa = document.getElementsByName('placa')[0].value;
        var validaAno = /^\d+$/;
        var validaPlaca = /^[A-Z]{3}\-\d{4}$/;
        
       
        if (validaAno.test(ano)==true && validaPlaca.test(placa)==true) {
            return true;
        } 
        else if (validaPlaca.test(placa)==false) {
            alert("Placa Inválida!");
            return false;
        }
        else if (validaAno.test(ano)==false) {
            alert("Verifique o ano. Apenas números são permitidos!");
            return false;
        }
        else{
            return false;
        }
    }
    function caps(){
        var placa = document.getElementsByName('placa')[0].value;
        var placaCaps = placa.toUpperCase();
        var insereTraco = placaCaps.replace(/^(\w{3})(\w{4})$/, "$1-$2");
        document.getElementsByName('placa')[0].value=insereTraco;
    }
    function excluirElement(id){
        $('#'+id).remove();
    }
</script>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Editar Carro</h3> 
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
        <form method="POST" action="{{ route('carro.update', $Carro->id) }}" enctype="multipart/form-data" onsubmit="return validaCampos();" >
            <input type="text" placeholder="Nome" name="nome" class="form-control" value="{{ $Carro->nome }}">
            <input type="text" placeholder="Placa" name="placa" class="form-control" maxlength="7" minlength="7" value="{{ $Carro->placa }}">
            <input type="text" placeholder="Modelo" name="modelo" class="form-control" value="{{ $Carro->modelo }}">
            <input type="text" placeholder="Ano" name="ano" class="form-control" maxlength="4" minlength="4" value="{{ $Carro->ano }}">
            <input type="text" placeholder="RFID" name="rfid" class="form-control" value="{{ $Carro->rfid }}">
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary" value="put"> Atualizar </button>
                @method('put')
                @csrf
            </div>

        </form>
    </div>
</div>

@endsection
