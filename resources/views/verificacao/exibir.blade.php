@extends('layouts.app')
@section('content')
	<script src="{{ asset('js/jquery.min.js') }}" ></script>
    <script src="{{ asset('js/xzoom.min.js') }}" ></script>
	<script type="text/javascript">
	    var avaria, fotos, metodos;    

	    window.onload = function(){
	        @php
	            echo "
	                metodos = new Metodos('metodos', '". csrf_token() ."');
	                avaria = new Avaria('avaria', '". csrf_token() ."', '". $local_avarias ."', '" . $tipo_avarias . "');
	        		avaria.carousel('divExibebeImagens', 'modalImg', '". $fotos ."'); 
	            ";
	        @endphp

			// EXIBE MENSAGEM DE SUCESSO E ERRO.
			jQuery(function($) {
                $(".xzoom").xzoom({
                    position: 'right',
                    Xoffset: 15
                });
            });
	    }
	</script>
<div class="wrapper fadeInDown">	

    <div id="formContent">	
	    <h3>Entrada</h3> <hr>

        {{-- DIV PARA EXIBIR MENSAGENS --}}
		@include('layouts.messages')

		{{-- DIV QUE EXIBE OS DADOS DA ENTRADA --}}
        <div class="container">
            <h5>Motorista: @empty($entradas->motorista->nome)<a href="/entrada/addMotorista/{{$entradas->id}}" class="iconesLista"><i class="fas fa-plus-circle"></i></a>@endempty @isset($entradas->motorista->nome){{$entradas->motorista->nome}}@endisset</h5>
            <h5>Carro: {{$entradas->carro->nome}} - {{$entradas->carro->placa}}</h5>
        </div>
        
       	{{-- DIV PARA EXIBIR AS IMAGENS --}}
		<div class="container" id="divExibebeImagens"></div>

        {{-- MODAL DA IMAGEM --}}
        <div id="modalImg"></div>
        
		<div class="container" style="padding-left: 0px; padding-right:0px;">
		<div class="accordion" id="accordionExample">
			@forelse ($verificacao->descAvaria as $avaria)
				<div class="card">
					{{-- BOTÃO PARA EXIBIR AS AVARIAS CADASTRADAS --}}
					<div class="card-header" id="heading{{ $avaria->id }}">
						<h5 class="mb-0">
							<button class="btn btn-link" type="button" data-toggle="collapse" 
								data-target="#collapse{{ $avaria->id }}" aria-expanded="false" 
								aria-controls="collapse{{ $avaria->id }}">
								Avaria {{ $avaria->id }}
							</button>
						</h5>
					</div>

					{{-- EXIBI AS OBSERVAÇÕES --}}
					<div id="collapse{{ $avaria->id }}" class="collapse" aria-labelledby="heading{{ $avaria->id }}" 
						data-parent="#accordionExample">
						<div class="card-body">

							{{-- PROCURA PELA DESCRIÇÃO DO LOCAL DA AVARIA --}}
							@foreach ($local_avarias as $local_avaria)
								@if ($avaria->local_avaria_id == $local_avaria->id)
									<input type="text" placeholder="Local Avaria" name="localAvaria" class="form-control" value="{{ $local_avaria->local }}" disabled>				
								@endif
							@endforeach

							{{-- PROCURA PELA DESCRIÇÃO DO TIPO DE AVARIA --}}
							@foreach ($tipo_avarias as $tipo_avaria)
								@if ($avaria->tipo_avaria_id == $tipo_avaria->id)
									<input type="text" placeholder="Local Avaria" name="localAvaria" class="form-control" value="{{ $tipo_avaria->tipo }}" disabled>				
								@endif
							@endforeach

							<input class="form-control" type="text" value="{{ $avaria->obs }} " name="obs" id="obs" disabled>
						</div>
					</div>
				</div>
			@empty
				<h3>Nenhuma Avaria Cadastrada</h3>
			@endforelse
		</div>
		</div>
	</div>
</div>
@endsection