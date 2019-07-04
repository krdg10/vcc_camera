@extends('motorista.layoutTabela')
@section('footerMotorista')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $motoristas->links() }}
    </div>
</div>
@endsection 