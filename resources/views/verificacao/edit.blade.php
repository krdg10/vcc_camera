@extends('layouts.app')
@section('content')
<script>
function excluirElement(id){
        $('#'+id).remove();
    }
</script>
<div class="wrapper fadeInDown">
    <div id="formContent">
	    <h3>Verificar entrada</h3>
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
       
		<div class="form-control"  style="height: 400px">
		    <div>
				<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				  <div class="carousel-inner">
				  	@foreach ($Fotos as $fotos)
					    <div class="carousel-item active">
					      <img class="d-block w-100" style="height: 300px" src="{{url('/storage/'.$fotos->path)}}" alt="Primeiro Slide">
					    </div>
				  	@endforeach
				    
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Anterior</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Próximo</span>
				  </a>
				</div>
		    </div>
		</div>
		<br>

		<div>
            @foreach ($Avarias as $avaria) 
				<form method="POST" action="{{ route('verificacao.update', $avaria->id) }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<h4>Avaria</h4>
					@foreach ($tipoAvaria as $tipo_avaria)
						@foreach ($localAvaria as $local_avaria)
							@if ($avaria->local_avaria_id == $local_avaria->id)
								<select class="MineSelect" name="localAvaria" id="localAvaria"> <!--tava form-control -->
									<option value="{{ $local_avaria->id }}">{{ $local_avaria->local }}</option>
									@foreach($localAvaria2 as $avarias)
										<option value="{{ $avarias->id }}"> {{ $avarias->local }}</option>
									@endforeach
								</select>
								<!--<input class="form-control" type="text" value="{{ $local_avaria->local }}">-->
							@endif
						@endforeach
						@if ($avaria->tipo_avaria_id == $tipo_avaria->id)
							<select class="MineSelect" name="tipoAvaria" id="tipoAvaria"> <!--tava form-control -->
									<option value="{{ $tipo_avaria->id }}">{{ $tipo_avaria->tipo }}</option>
									@foreach($tipoAvaria2 as $tipos)
										<option value="{{ $tipos->id }}"> {{ $tipos->tipo }}</option>
									@endforeach
								</select>
								<!--<input class="form-control" type="text" value="{{ $tipo_avaria->tipo }}">-->
						@endif
					@endforeach
					@if ($avaria->verificacao_id == $Verificacao->id)
						<input class="form-control" type="text" value="{{ $avaria->obs }} " name="obs" id="obs">
					@endif
					<button type="submit" id="submit" class="btn btn-outline-primary"> Atualizar Avaria </button>
				</form>
            @endforeach
		    <div id="formFooter">
                <div id="marcaCheck"><label>Verificado:</label><input type="checkbox" name="verificado" id="verificado" value="1" class="form-control" checked disabled></div>
		    </div>
		</div>
	</div>
</div>
@endsection