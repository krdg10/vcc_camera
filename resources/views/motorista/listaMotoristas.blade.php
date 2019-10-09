@extends('motorista.layoutTabela')

@section('tagsMotorista')
    @include('layouts.messages')
@endsection

@section('footerMotorista')
    <div id="formFooter">
        <div class="d-flex justify-content-center">
            {{ $motoristas->onEachSide(1)->links() }}
        </div>
    </div>
@endsection 