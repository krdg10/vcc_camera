@extends('carro.layoutTabela')
@section('tagsCarro')
@if($nome!=NULL || $placa!=NULL || $ano!=NULL || $modelo!=NULL || $rfid!=NULL)
    <h5>Termos Buscados</h5>
    @if($nome!=NULL)
        <span id="nomeBusca" class="badge badge-primary badge-pill">
            {{$nome}} 
        </span>
    @endif
    @if($placa!=NULL)
        <span id="placaBusca" class="badge badge-primary badge-pill">
            {{$placa}} 
        </span>
    @endif
    @if($ano!=NULL)
        <span id="anoBusca" class="badge badge-primary badge-pill">
            {{$ano}} 
        </span>
    @endif
    @if($modelo!=NULL)
        <span id="modeloBusca" class="badge badge-primary badge-pill">
            {{$modelo}} 
        </span>
    @endif
    @if($rfid!=NULL)
        <span id="rfidBusca" class="badge badge-primary badge-pill">
            {{$rfid}} 
        </span>
    @endif
@endif
@endsection
@section('footerCarro')
<div id="formFooter">
    <div class="d-flex justify-content-center">
    {{ $carros->appends(['nome' => $nome, 
        'placa' => $placa, 'modelo' => $modelo, 'ano' => $ano, 'ativo' => $ativo, 'rfid' => $rfid])->links() }}
    </div>
</div>
@endsection 
