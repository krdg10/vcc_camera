@extends('carro.layoutTabela')
@section('tagsCarro')
    @include('layouts.messages')
@endsection
@section('footerCarro')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $carros->onEachSide(1)->links() }}
    </div>
</div>
@endsection 
