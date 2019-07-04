
@extends('entrada.exibir')

@section('footer')
<div id="formFooter">
    <div class="d-flex justify-content-center">
        {{ $entradas->links() }}
    </div>
</div>
@endsection 
