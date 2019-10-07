@extends('layouts.app')
@section('content')
<script>
    function valida() {
        var cpf = document.getElementsByName('cpf')[0].value;
        var codigo_empresa = document.getElementsByName('codigo_empresa')[0].value;
        var codigo_transdata = document.getElementsByName('codigo_transdata')[0].value;
        var nome = document.getElementsByName('nome')[0].value;
        if(document.getElementById('ativo').checked == true){
            var ativo = document.getElementsByName('ativo')[0].value;
        }
        else{
            var ativo = null;
        }
        var temCaracterAlfanumerico = /\w$/;
        var valida = /^\d+$/;
        if(temCaracterAlfanumerico.test(cpf) == false  && temCaracterAlfanumerico.test(codigo_empresa) == false && temCaracterAlfanumerico.test(codigo_transdata) == false && temCaracterAlfanumerico.test(nome) == false && ativo==null){
            alert("Digite caracteres alfanuméricos ou selecione algum filtro de pesquisa!");
            return false;
        }
        if ((cpf == '' || (cpf != '' && valida.test(cpf)==true)) && (codigo_empresa == '' || (codigo_empresa != '' && valida.test(codigo_empresa)==true)) && (codigo_transdata == '' || (codigo_transdata != '' && valida.test(codigo_transdata)==true )) || ativo == '0') {
            return true;
        } 
        else if (valida.test(cpf)==false){
            alert("Verifique o CPF. Apenas números são permitidos!");
            return false;
        }
        else if (valida.test(codigo_empresa)==false){
            alert("Verifique o código da empresa. Apenas números são permitidos!");
            return false;
        }
        else if (valida.test(codigo_transdata)==false){
            alert("Verifique o código transdata. Apenas números são permitidos!");
            return false;
        }
        else {
            return false;
        }
    }
</script>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">
            <h3>Lista de Motoristas </h3>
            @yield('tagsMotorista')
            <p><a data-toggle="modal" href="#modalBusca" data-target="#modalBusca"><i class="fas fa-search">Buscar</i></a></p>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Código VCC</th>
                        <th>Código Transdata</th>
                        <th>Apagar/
                        Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($motoristas)==0)
                        <h3>Nenhum Motorista Encontrado</h3>
                    @endif
                    @foreach ($motoristas as $motorista)
                        <tr>
                            <td>{{$motorista->nome}}</td>
                            <td>{{$motorista->cpf}}</td>
                            <td>{{$motorista->codigo_empresa}}</td>
                            <td>{{$motorista->codigo_transdata}}</td>
                            <td><div class="p-2 iconesLista"><a href="{{ url('/motorista/listar/excluir/'.$motorista->id) }}">  <i class="fas fa-trash"></i> </a> <a href="{{ url('/motorista/listar/'.$motorista->id) }}"> <i class="fas fa-edit"></i></a></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @yield('footerMotorista')
        </div>
    </div>
</div>
<div class="modal fade" id="modalBusca" tabindex="-1" role="dialog" aria-labelledby="busca" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="formConten">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar Motorista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="fadeIn first">
                <form method="POST" action="{{route('motorista.busca')}}" enctype="multipart/form-data" onsubmit="return valida();">
                    @csrf
                    <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control" max="250">
                    <input type="text" name="cpf" id="cpf" placeholder="CPF" class="form-control" maxlength="11" minlength="11">
                    <input type="text" name="codigo_empresa" id="codigo_empresa" placeholder="Código VCC" class="form-control" maxlength="4" minlength="4">
                    <input type="text" name="codigo_transdata" id="codigo_transdata" placeholder="Código Transdata" class="form-control" maxlength="5" minlength="5">
                    <ul class="ks-cboxtags">
                        <li>
                            <input type="checkbox" name="ativo" id="ativo" placeholder="Ativo" value="0"><label for="ativo">Buscar Inativos</label>
                        </li>
                    </ul>
                    <div id="formFooter">
                        <button type="submit" id="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 @endsection