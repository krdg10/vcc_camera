@extends('layouts.app')
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Carro</h3> <hr>
        <form method="POST" action="{{ route('carro.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
            <input type="text" placeholder="Nome" name="nome" class="form-control">
            <input type="text" placeholder="Placa" name="placa" class="form-control">
            <input type="text" placeholder="Modelo" name="modelo" class="form-control">
            <input type="text" placeholder="Ano" name="ano" class="form-control">
            <div id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>

        </form>
    </div>
</div>
@endsection
