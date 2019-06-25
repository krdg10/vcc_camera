@extends('layouts.app')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
    	@php
    		// dd($entradas->fotos)	
    	@endphp
	    <h3>Verificar entrada</h3> <hr>
		<div class="form-control" >

		    <div>
		    	<label>Nome</label> {{$entradas->motorista->nome}}
		    </div>

			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
			  <div class="carousel-inner">
			  	@foreach ($entradas->fotos as $fotos)
				    <div class="carousel-item active">
				      <img class="d-block w-100" src="{{Storage::url($fotos->path)}}" alt="Primeiro Slide">
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
		<br>

		<form method="post" action="/verificacoa">
	    	{{ csrf_field() }}

			{{-- LOCAL DA AVARIA --}}
			<div class="form-control" >
				<label>Local da avaria: </label>
				<select name="localAvaria" class="form-item" onclick="verificar(this)">
					@for ($i = 0; $i < $localAvarias->count(); $i++)
						<option value="{{$localAvarias[$i]->id}}">{{$localAvarias[$i]->local}}</option>
					@endfor
				</select>
			</div>

			{{-- TIPO DE AVARIA --}}
			<div class="form-control" >
				<label>Tipo da avaria: </label>
				<select id="tipoAvaria"  name="tipoAvaria" disabled="">
					@for ($i = 0; $i < $tipoAvarias->count(); $i++)
						<option value="{{$tipoAvarias[$i]->id}}">{{$tipoAvarias[$i]->local}}</option>
					@endfor
				</select>
			</div>

			{{-- CAMPO DE OBSERVAÇÃO --}}
			<div class="form-control" >
	        	<input type="textArea" placeholder="Observação" name="observacao" >
	        </div>

	        <div id="formFooter">
	            <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
	        </div>
		</form>
	</div>
</div>

<script type="text/javascript">
	function verificar(localAvaria){
		var tipoAvaria = document.getElementById('tipoAvaria')
		if(localAvaria.value == 1){
			tipoAvaria.disabled = true;
			tipoAvaria.value = 1;
		}
		else{
			tipoAvaria.disabled = false;
		}
	}
</script>
@endsection
