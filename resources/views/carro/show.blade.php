@extends('carro.layoutTabela')
@section('tagsCarro')
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
@endsection
@section('footerCarro')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $carros->onEachSide(1)->links() }}
    </div>
</div>
@endsection 
