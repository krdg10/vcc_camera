@extends('layouts.app')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
	    <h3>Verificar entrada</h3> <hr>
		<div class="form-control"  style="height: 400px">
		    <div>
		    	<label>Nome: </label> {{$entradas->motorista->nome}}

				<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				  <div class="carousel-inner">
				  	@foreach ($entradas->fotos as $fotos)
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
			<button onclick="novaVerificacao()">Nova</button>
			<div id="divCreteVerificacao">
				
			</div>

			<form method="post" action="/verificacoa">
		    	{{ csrf_field() }}

		        <div id="formFooter">
		            <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
		        </div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	@php
		echo "var localAvarias = JSON.parse('" . $localAvarias ."');";
		echo "var tipoAvarias = JSON.parse('" . $tipoAvarias ."');";
	@endphp
	
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

	function novaVerificacao(){
		var optionLocalAVaria = '';
		var optionTipoAVaria = '';

		for (var i = 0; i < localAvarias.length; i++)
			optionLocalAVaria += '<option value="' + localAvarias[i].id + '">' + localAvarias[i].local + '</option>';

		for (var x = 0; x < tipoAvarias.length; x++)
			optionTipoAVaria += '<option value="' + tipoAvarias[x].id + '">' + tipoAvarias[x].local + '</option>';
		
			
		var div = '' +
			//LOCAL DA AVARIA
			'<label>Local da avaria: </label> ' + 
			'<select name="localAvaria" class="form-item" onclick="verificar(this)"> ' + 
				optionLocalAVaria+
			'</select>' + 

			// TIPO DE AVARIA
			'<label>Tipo da avaria: </label>' + 
			'<select id="tipoAvaria"  name="tipoAvaria" disabled="">' + 
				optionLocalAVaria +
			'</select>' + 

			//CAMPO DE OBSERVAÇÃO 
        	'<input type="textArea" placeholder="Observação" name="observacao" >'+
        	'<hr>'
        	;

		var objDiv = document.createElement('div');
		objDiv.innerHTML = div;

		document.getElementById("divCreteVerificacao").appendChild(objDiv);
	}
</script>
@endsection
