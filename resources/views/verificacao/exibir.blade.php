@extends('layouts.app')
@section('content')
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
		
		<div class="accordion" id="accordionExample"> <!-- um tempo testando. primeiro com um if. ai depois colocando  nas ids de um if. depois só . ai funcionou e foi geral. Ver nome depois. -->
			@if(count($Avarias)==0)
				<h3>Nenhuma Avaria Cadastrada</h3>
			@endif
			@foreach ($Avarias as $avaria)
				<div class="card">
					<div class="card-header" id="heading{{ $avaria->id }}">
						<h5 class="mb-0">
							<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $avaria->id }}" aria-expanded="false" aria-controls="collapse{{ $avaria->id }}">
							Avaria {{ $avaria->id }}
							</button>
						</h5>
					</div>
					<div id="collapse{{ $avaria->id }}" class="collapse" aria-labelledby="heading{{ $avaria->id }}" data-parent="#accordionExample">
						<div class="card-body">
							@foreach ($tipoAvaria as $tipo_avaria)
								@foreach ($localAvaria as $local_avaria)
									@if ($avaria->local_avaria_id == $local_avaria->id)
										<input type="text" placeholder="Local Avaria" name="localAvaria" class="form-control" value="{{ $local_avaria->local }}" disabled>				
									@endif
								@endforeach
								@if ($avaria->tipo_avaria_id == $tipo_avaria->id)
									<input type="text" placeholder="Tipo Avaria" name="tipoAvaria" class="form-control" value="{{ $tipo_avaria->tipo }}" disabled>		
								@endif
							@endforeach
							@if ($avaria->verificacao_id == $Verificacao->id)
								<input class="form-control" type="text" value="{{ $avaria->obs }} " name="obs" id="obs" disabled>
							@endif	
						</div>
					</div>
				</div>
			@endforeach
		</div>
		<div id="formFooter">
           <!-- <div id="marcaCheck"><label>Verificado:</label><input type="checkbox" name="verificado" id="verificado" value="1" class="form-control" checked disabled></div> -->
		</div>
	</div>
	</div>
</div>
@endsection