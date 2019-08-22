@extends('layouts.app')
@section('content')
<div id="formContent">
    <form method="POST" action="{{ route('motorista.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
        <input type="text" placeholder="Nome" name="nome" class="form-control">
        <input type="text" placeholder="CPF" name="cpf" class="form-control">
        <input type="text" placeholder="Data de Nascimento" name="data_nascimento" class="form-control">
        <input type="text" placeholder="Código VCC" name="codigo_empresa" class="form-control">
        <input type="text" placeholder="Código Transdata" name="codigo_transdata" class="form-control">
        <button type="submit" id="submit" class="btn btn-outline-success"> Salvar </button>

    </form>
</div>
@endsection
