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
<!-- não precede de \ [a-z]. Deixar \w na segunda pra por o traço independente do caracter --> 
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Carro</h3> 
        @include('layouts.messages')
        <hr>
        <form method="POST" action="{{ route('carro.store') }}" enctype="multipart/form-data" onsubmit="return validaCampos();">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="nome">Nome <a class="color-red">*</a></label>
                <input type="text" placeholder="Nome" name="nome" class="form-control" required maxlength="250" value="{{\Session::get('resposta')["nome"]}}">
            </div>
            <div class="form-group">
                <label for="placa">Placa <a class="color-red">*</a></label>
                <input type="text" placeholder="Placa" name="placa" class="form-control" maxlength="8" minlength="8" onblur="caps();" required value="{{\Session::get('resposta')["placa"]}}">
            </div>
            <div class="form-group">
                <label for="modelo">Modelo <a class="color-red">*</a></label>
                <input type="text" placeholder="Modelo" name="modelo" class="form-control" required maxlength="250" value="{{\Session::get('resposta')["modelo"]}}">
            </div>
            <div class="form-group">
                <label for="ano">Ano <a class="color-red">*</a></label>
                <input type="text" placeholder="Ano" name="ano" class="form-control" maxlength="4" minlength="4" value="{{\Session::get('resposta')["ano"]}}">
            </div>
            <div class="form-group">
                <label for="rfid">RFID <a class="color-red">*</a></label>
                <input type="text" placeholder="RFID" name="rfid" class="form-control" required maxlength="250" value="{{\Session::get('resposta')["rfid"]}}">
            </div>
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>

        </form>
    </div>
</div>
@endsection
