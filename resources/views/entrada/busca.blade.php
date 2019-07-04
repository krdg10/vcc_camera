@extends('entrada.exibir')
@section('search')
@if($nome!=NULL || $carro!=NULL || $horario!=NULL)
    <h5>Termos Buscados</h5>
    @if($nome!=NULL)
        <span id="nomeBusca" class="badge badge-primary badge-pill">
            {{$nome}} 
        </span>
    @endif
    @if($carro!=NULL)
        <span id="carroBusca" class="badge badge-primary badge-pill">
            {{$carro}} 
        </span>
    @endif
    @if($horario!=NULL)
        <span id="horarioBusca" class="badge badge-primary badge-pill">
            {{$horario}} 
        </span>
    @endif
@endif
@endsection

@section('footer')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $entradas->appends(['nome' => $nome, 'horario' => $horario, 
        'carro' => $carro, 'verificado' => $verificado])->links() }}
    </div>
</div>
@endsection