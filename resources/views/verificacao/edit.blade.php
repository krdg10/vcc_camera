@extends('layouts.app')
@section('content')
<script>

    var avarias = [];
    var cont = 0;
    window.onload = function(){
        $('#addAvaria').click(function(){
            var local = $('#localAvariaNovo').val()
            var tipo = $('#tipoAvariaNovo').val()
            var obs = $('#observacaoNovo').val()
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
                @php 
                    $tester=1;
                @endphp
				<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				  <div class="carousel-inner">
				  	@foreach ($Fotos as $fotos)
                        @if($tester==1)
					    <div class="carousel-item active">
					      <img class="d-block w-100" style="height: 300px" src="{{url('/storage/'.$fotos->path)}}" alt="Primeiro Slide">
					    </div>
                            @php
                                $tester=2;
                            @endphp
                        @else
                        <div class="carousel-item">
					      <img class="d-block w-100" style="height: 300px" src="{{url('/storage/'.$fotos->path)}}" alt="Slide Secundário">
					    </div>
                        @endif
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

		<div class="accordion" id="accordionExample">
			<div class="card">
				<div class="card-header" id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						Editar Avarias Existentes
						</button>
					</h5>
				</div>

				<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					<div class="card-body">
						<div class="accordion" id="accordionInterno">
							@foreach ($Avarias as $avaria) 
								<form method="POST" action="{{ route('verificacao.update', $avaria->id) }}" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="card">
										<div class="card-header" id="heading{{$avaria->id}}">
											<h5 class="mb-0">
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$avaria->id}}" aria-expanded="false" aria-controls="collapse{{$avaria->id}}">
												Avaria {{ $avaria->id }} <!-- contar quantidade de avaria certo -->
												</button>
											</h5>
										</div>
										<div id="collapse{{$avaria->id}}" class="collapse" aria-labelledby="heading{{ $avaria->id }}" data-parent="#accordionInterno">
											<div class="card-body">
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
												<button type="submit" id="submit" class="btn btn-outline-primary" formaction="{{ route('descavarias.destroy', $avaria->id) }}" > Excluir </button>
											</div>
										</div>
									</div>
								</form>
							@endforeach
						</div> <!-- end acordion interno -->
					</div>
				</div>
			</div> 
		
		

			<div class="card">
				<div class="card-header" id="headingTwo">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
						Adicionar Avarias Novas
						</button>
					</h5>
				</div>
				<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
					<div class="card-body">
						<form method="POST" action="{{ route('descavarias.store', $Verificacao->id) }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<h4 style="margin-top: 0.5rem">Inserir Avaria Nova</h4>
							<select class="MineSelect" name="localAvariaNovo" id="localAvariaNovo"> <!--tava form-control -->
								<option value="false"> Selecione uma opção </option>
								@foreach($localAvaria as $avaria)
									<option value="{{ $avaria->id }}"> {{ $avaria->local }}</option>
								@endforeach 
							</select>
							<select class="MineSelect" name="tipoAvariaNovo" id="tipoAvariaNovo"  onchange="storeLocalAVaria(this)"> <!--tava form-control -->
								<option value="false"> Selecione uma opção </option>
								@foreach($tipoAvaria as $avaria)
									<option value="{{ $avaria->id }}"> {{ $avaria->tipo }}</option>
								@endforeach 
							</select>
							<div id="addObs">
								<input type="text" placeholder="Observação" name="observacaoNovo" id="observacaoNovo" class="form-control">
								
								<button id="addAvaria" type="button" class="btn-circle btn-outline-primary">+</button>
							</div>
							<div id="avarias"></div>
							<button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Cadastrar nova avaria </button>
						</form>
					</div>
				</div>
			</div>
           
		    <div id="formFooter">
                <div id="marcaCheck"><label>Verificado:</label><input type="checkbox" name="verificado" id="verificado" value="1" class="form-control" checked disabled></div>
		    </div>
		</div>
	</div>
</div>
@endsection