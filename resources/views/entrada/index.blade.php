@extends('layouts.app')
@section('content')
<div id="formContent">
    <form method="POST" action="{{ route('entrada.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
        <select class="formControl" name="motorista">
            @foreach($motorista as $Motorista) 
                <option value="{{ $Motorista->id }}"> {{ $Motorista->nome }} </option>
            @endforeach
        </select>
        <select class="formControl" name="carro">
            @foreach($carro as $Carro)
                <option value="{{ $Carro->id }}"> {{ $Carro->nome }} - {{ $Carro->placa }} </option>
            @endforeach
        </select>

        <input type="datetime-local" placeholder="Horário" name="horario" class="form-control">
       
        <button type="submit" id="submit" class="btn btn-outline-success"> Salvar </button>

    </form>
</div>
@endsection
