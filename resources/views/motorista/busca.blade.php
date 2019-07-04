@extends('motorista.layoutTabela')
@section('tagsMotorista')
@if($nome!=NULL || $cpf!=NULL || $codigo_empresa!=NULL || $codigo_transdata!=NULL)
    <h5>Termos Buscados</h5>
    @if($nome!=NULL)
        <span id="nomeBusca" class="badge badge-primary badge-pill">
            {{$nome}} 
        </span>
    @endif
    @if($cpf!=NULL)
        <span id="cpfBusca" class="badge badge-primary badge-pill">
            {{$cpf}} 
        </span>
    @endif
    @if($codigo_empresa!=NULL)
        <span id="codigoEmpresaBusca" class="badge badge-primary badge-pill">
            {{$codigo_empresa}} 
        </span>
    @endif
    @if($codigo_transdata!=NULL)
        <span id="codigoTransdataBusca" class="badge badge-primary badge-pill">
            {{$codigo_transdata}} 
        </span>
    @endif
@endif
@endsection

@section('footerMotorista')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $motoristas->appends(['nome' => $nome, 
        'cpf' => $cpf, 'codigo_empresa' => $codigo_empresa, 'codigo_transdata' => $codigo_transdata])->links() }}
    </div>
</div>
@endsection 