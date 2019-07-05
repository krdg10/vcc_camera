@extends('carro.layoutTabela')
@section('footerCarro')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $carros->links() }}
    </div>
</div>
@endsection 
