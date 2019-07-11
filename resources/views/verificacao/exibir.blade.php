@extends('layouts.app')
@section('content')
<div class="wrapper fadeInDown">
	<script type="text/javascript">
	    var avaria, fotos;    
	    var cont = 0;
	    var metodos;

	    window.onload = function(){
	        @php
	            echo "
	                metodos = new Metodos('". csrf_token() ."');
	                avaria = new Avaria('avaria', '". $local_avarias ."', '" . $tipo_avarias . "');
	        		avaria.carousel('divExibebeImagens', 'modalImg', '". $fotos ."'); 
	            ";
	        @endphp

	        // EXIBE MENSAGEM DE SUCESSO E ERRO.
	        @if( \Session::has('error') )
	            @foreach(session()->get('error') as $key => $ms)
	                metodos.msgError("{{ $ms }}", 'divMsg');
	            @endforeach
	        @endif
	        @if( \Session::has('message') )
	            metodos.msgSuccess("{{ \Session::get('message') }}", 'divMsg');
	        @endif
	    }
	</script>

    <div id="formContent">	
	    <h3>Verificar entrada</h3>

        {{-- DIV PARA EXIBIR MENSAGENS --}}
        <div id="divMsg"></div>
        
       	{{-- DIV PARA EXIBIR AS IMAGENS --}}
		<div class="form-control" id="divExibebeImagens" style="height: 400px"></div>

        {{-- MODAL DA IMAGEM --}}
        <div id="modalImg"></div>
		
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
@endsection