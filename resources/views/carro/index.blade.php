@extends('layouts.app')
@section('content')
<div id="formContent">
    <form method="POST" action="{{ route('carro.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
        <input type="text" placeholder="Nome" name="nome" class="form-control">
        <input type="text" placeholder="Placa" name="placa" class="form-control">
        <input type="text" placeholder="Modelo" name="modelo" class="form-control">
        <input type="text" placeholder="Ano" name="ano" class="form-control">
        <button type="submit" id="submit" class="btn btn-outline-success"> Salvar </button>

    </form>
</div>
@endsection
