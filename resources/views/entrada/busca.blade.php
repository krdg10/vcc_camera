@extends('entrada.modeloListagem')
@section('search')
@if($nome!=NULL || $carro!=NULL || $horario!=NULL || $n_verificado!=NULL || $verificado!=NULL)
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
    @if($n_verificado!=NULL)
        <span id="n_verificadoBusca" class="badge badge-primary badge-pill">
            Não Verificados
        </span>
    @endif
    @if($verificado!=NULL)
        <span id="verificadoBusca" class="badge badge-primary badge-pill">
            Verificados
        </span>
    @endif
@endif
@endsection

@section('footer')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $entradas->appends(['nome' => $nome, 'horario' => $horario, 
        'carro' => $carro, 'verificado' => $verificado, 'n_verificado' => $n_verificado])->onEachSide(1)->links() }}
    </div>
</div>
@endsection