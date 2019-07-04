@extends('entrada.exibir')

@section('footer')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $entradas->appends(['nome' => $nome, 'horario' => $horario, 
        'carro' => $carro, 'verificado' => $verificado])->links() }}
    </div>
</div>
@endsection