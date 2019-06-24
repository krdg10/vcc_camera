@extends('layouts.app')
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Entrada</h3> <hr>
        <form method="POST" action="{{ route('entrada.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
            <select class="form-control" name="motorista">
                <option value="false"> Selecione um motorista</option>
                @foreach($motorista as $Motorista) 
                    <option value="{{ $Motorista->id }}"> {{ $Motorista->nome }} </option>
                @endforeach
            </select>
            <select class="form-control" name="carro">
                <option value="false"> Selecione um carro</option>
                @foreach($carro as $Carro)
                    <option value="{{ $Carro->id }}"> {{ $Carro->nome }} - {{ $Carro->placa }} </option>
                @endforeach
            </select>

            <input type="datetime-local" placeholder="Horário" name="horario" class="form-control">
            <input type="file" aria-label="foto" id="foto" name="fotos[]" class="form-control" multiple />
            
            <div id="formFooter">
              <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>
        </form>
    </div>
</div>

  

   

@endsection
