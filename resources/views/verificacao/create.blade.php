@extends('layouts.app')

@section('content')
<script>
    var avarias = []
    var cont = 0
    window.onload = function(){
        $('#addAvaria').click(function(){
            var local = $('#localAvaria').val()
            var tipo = $('#tipoAvaria').val()
			var obs = $('#observacao').val()
            if (local == 'false' || tipo == 'false'){
                return alert('Selecione local e tipo.')
            }
            var text = ''
            if(local && tipo){
                avarias.push({ 'id': cont, 'loc': local, 'tip': tipo, 'ob': obs })
                cont++
                console.log(avarias)
            }
            for(i in avarias){
                text += ' <span id="'+avarias[i].id+'" class="badge badge-primary badge-pill">'+avarias[i].loc+' - '+avarias[i].tip+' - '+avarias[i].ob+' <input type="text" value="'+avarias[i].loc+'" name="local[]" class="d-none"> <input type="text" value="'+avarias[i].tip+'" name="tipo[]" class="d-none"> <input type="text" value="'+avarias[i].ob+'" name="obs[]" class="d-none">  <a id="excluir" onClick="excluir(`'+avarias[i].id+'`)"><i class="fa fa-times" aria-hidden="true"></i></a> </span>'
            }
            element = document.getElementById('avarias')
            element.innerHTML = text
        })
    }
    function excluir(id){
        var remove = -1
        for(i in avarias){
            if(id == avarias[i].id){
                avarias.splice(i, 1);
                break;
            }
        }
        var text = ''
        for(i in avarias){
            text += ' <span id="'+avarias[i].id+'" class="badge badge-primary badge-pill">'+avarias[i].loc+' - '+avarias[i].tip+' - '+avarias[i].ob+' <input type="text" value="'+avarias[i].loc+'" name="local[]" class="d-none"> <input type="text" value="'+avarias[i].tip+'" name="tipo[]" class="d-none"> <input type="text" value="'+avarias[i].obs+'" name="obs[]" class="d-none"> <a id="excluir" onClick="excluir(`'+avarias[i].id+'`)"><i class="fa fa-times" aria-hidden="true"></i></a> </span>'
        }
        element = document.getElementById('avarias')
        element.innerHTML = text
    }
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
		<form method="POST" action="{{ route('verificacao.store', $entradas->id) }}" enctype="multipart/form-data">
		    	{{ csrf_field() }}
			<h4 style="margin-top: 0.5rem">Inserir Avaria (Caso Haja)</h4>
			<select class="MineSelect" name="localAvaria" id="localAvaria"> <!--tava form-control -->
                <option value="false">Selecione o local da Avaria</option>
                @foreach($localAvarias as $avaria)
                    <option value="{{ $avaria->id }}"> {{ $avaria->local }}</option>
                @endforeach
            </select>
			<select class="MineSelect" name="tipoAvaria" id="tipoAvaria"> <!--tava form-control -->
                <option value="false">Selecione o tipo da Avaria</option>
                @foreach($tipoAvarias as $avaria)
                    <option value="{{ $avaria->id }}"> {{ $avaria->tipo }}</option>
                @endforeach
            </select>


			
            <div id="addObs">
        	<input type="text" placeholder="Observação" name="observacao" id="observacao" class="form-control">
        	
			<button id="addAvaria" type="button" class="btn-circle btn-outline-primary">+</button>
            </div>
			<div id="avarias"></div>

			

		        <div id="formFooter">
                    <div id="marcaCheck"><label>Verificado:</label><input type="checkbox" name="verificado" id="verificado" value="1" class="form-control" checked></div>

		            <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
		        </div>
			</form>
		</div>
	</div>
</div>
@endsection
