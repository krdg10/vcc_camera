@extends('layouts.app')
@section('content')
<script> 
    function validaCampos() {
        var ano = document.getElementsByName('ano')[0].value;
        var placa = document.getElementsByName('placa')[0].value;
        var modelo = document.getElementsByName('modelo')[0].value;
        var nome = document.getElementsByName('nome')[0].value;
        if(document.getElementById('ativo').checked == true){
            var ativo = document.getElementsByName('ativo')[0].value;
        }
        else{
            var ativo = null;
        }
        var validaAno = /^\d+$/;
        var validaPlaca = /^[A-Z]{3}\-\d{4}$/;
        var temCaracterAlfanumerico = /\w$/;
        if(temCaracterAlfanumerico.test(ano) == false  && temCaracterAlfanumerico.test(placa) == false && temCaracterAlfanumerico.test(modelo) == false && temCaracterAlfanumerico.test(nome) == false && ativo==null){
            alert("Digite caracteres alfanuméricos ou selecione algum campo de pesquisa!");
            return false;
        }
        if ((ano == '' || (ano != '' && validaAno.test(ano)==true)) && (placa == '' || (placa != '' && validaPlaca.test(placa)==true)) || ativo == '0') {
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
        <div class="fadeIn first">
            <h3>Lista de Carros</h3>
            @yield('tagsCarro')
            <p><a data-toggle="modal" href="#modalBusca" data-target="#modalBusca"><i class="fas fa-search">Buscar</i></a></p>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>Apagar/ Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($carros)==0)
                        <h3>Nenhum Veículo Encontrado</h3>
                    @endif
                    @foreach ($carros as $carro)
                        <tr>
                            <td>{{$carro->nome}}</td>
                            <td>{{$carro->placa}}</td>
                            <td>{{$carro->modelo}}</td>
                            <td>{{$carro->ano}}</td>
                            <td><div class="p-2 iconesLista"><a href="{{ url('/carro/listar/excluir/'.$carro->id) }}"> <i class="fas fa-trash"></i> </a> <a href="{{ url('/carro/listar/'.$carro->id) }}"> <i class="fas fa-edit"></i></a></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @yield('footerCarro')
        </div>
    </div>
</div>
<div class="modal fade" id="modalBusca" tabindex="-1" role="dialog" aria-labelledby="busca" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="formConten">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar Veículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="fadeIn first">
                <form method="POST" action="{{route('carro.busca')}}" enctype="multipart/form-data" onsubmit="return validaCampos();">
                    @csrf
                    <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control">
                    <input type="text" name="placa" id="placa" placeholder="Placa" class="form-control" maxlength="7" minlength="7" onblur="caps();">
                    <input type="text" name="modelo" id="modelo" placeholder="Modelo" class="form-control">
                    <input type="text" name="ano" id="ano" placeholder="Ano" class="form-control" maxlength="4" minlength="4">
                    <label>Buscar Inativos: </label><input type="checkbox" name="ativo" id="ativo" placeholder="Ativo" class="form-control" value="0">
                    <div id="formFooter">
                        <button type="submit" id="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection