@extends('layouts.app')
@section('content')
<script> 
    function excluirElement(id){
        $('#'+id).remove();
    }
</script>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Entrada</h3>
        {{-- Exibe mensagem de sucesso ou de erro caso haja. --}}
        @if( \Session::has('error') )
            @foreach(session()->get('error') as $key => $ms)
                <span id="{{ $key }}error" class="badge badge-danger badge-pill">
                    {{ $ms }}
                    <a id="excluir" onClick="excluirElement('{{ $key }}error')"><i class="fa fa-times" aria-hidden="true"></i></a>
                </span>
            @endforeach
        @endif
        @if( \Session::has('message') )
            <span id="success" class="badge badge-success badge-pill">
                {{ \Session::get('message') }}
                    <a id="excluir" onClick="excluirElement('success')"><i class="fa fa-times" aria-hidden="true"></i></a>
            </span>
        @endif 
        
        <hr>
        <form method="POST" action="{{ route('entrada.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
            <select class="MineSelect" name="motorista">
                <option value="false"> Selecione um motorista</option>
                @foreach($motorista as $Motorista) 
                    <option value="{{ $Motorista->id }}"> {{ $Motorista->nome }} </option>
                @endforeach
            </select>
            <select class="MineSelect" name="carro">
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
