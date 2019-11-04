@extends('layouts.app')
@section('content')
	<script>
	    var avarias = [];
	    var cont = 0;
		var metodos, avaria;
	    window.onload = function(){
	        @php
	            echo "
	                metodos = new Metodos('". csrf_token() ."');
	                avaria = new Avaria('avaria', '". csrf_token() ."', '". $local_avarias ."', '" . $tipo_avarias . "'); 
	        		avaria.carousel('divExibebeImagens', 'modalImg', '". $entradas->fotos ."');
	            ";
			@endphp
			
	        // SETA DINAMICAMENTE OS CAMPOS DA SELECT
	        @foreach ($verificacao->descAvaria as $a)
        		avaria.setSelect('localAvaria{{$a->id}}', 'local', {{$a->local_avaria_id}}, false);
	        	avaria.setSelect('tipoAvaria{{$a->id}}', 'tipo', {{$a->tipo_avaria_id}}, false);
        	@endforeach

	        avaria.setSelect('localAvariaNovo', 'local');
	        avaria.setSelect('tipoAvariaNovo', 'tipo');

	        // EXIBE MENSAGEM DE SUCESSO E ERRO.
	        
	    }
	</script>


	<div class="wrapper fadeInDown">
	    <div id="formContent">
		    <h3>Verificar entrada</h3> <hr>

		    {{-- DIV PARA EXIBIR MENSAGENS --}}
		    @include('layouts.messages')

            {{-- MODAL DA IMAGEM --}}
            <div id="modalImg"></div>

	        {{-- EXIBE OS DADOS DO MOTORISTA --}}
	        <div class="container">
	            <h5>Motorista: @empty($entradas->motorista->nome)<a href="/entrada/addMotorista/{{$entradas->id}}" class="iconesLista"><i class="fas fa-plus-circle"></i></a>@endempty @isset($entradas->motorista->nome){{$entradas->motorista->nome}}@endisset</h5>
	            <h5>Carro: {{$entradas->carro->nome}} - {{$entradas->carro->placa}}</h5>
	        </div>
	       
       		{{-- DIV PARA EXIBIR AS IMAGENS --}}
			<div class="container" id="divExibebeImagens" ></div>

			{{-- VISUALIZAR OS CAMPO PARA EDITAR E ATUALIZAR --}}
			<div class="container" style="padding-left: 0px; padding-right:0px;">
			<div class="accordion" id="accordionExample">
				<div class="card">
					{{-- BOTÃO PARA EXIBIR OS DADOS CADASTRADOS --}}
					<div class="card-header" id="headingOne">
						<h5 class="mb-0">
							<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
								Editar ou Excluir Avarias Existentes
							</button>
						</h5>
					</div>

					{{-- EXIBE AS INFORMAÇÕES JÁ CADASTRADAS --}}
					<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="accordion" id="accordionInterno">

								@forelse ($verificacao->descAvaria as $avaria) 
									<form method="POST" action="{{ route('verificacao.update', $avaria->id) }}" enctype="multipart/form-data">
    									@csrf
										@method('put')
										<div class="card">
											{{-- BOTÃO PARA EXIBIR OS DADOS PARA EDIÇÃO DA AVARIA --}}
											<div class="card-header" id="heading{{$avaria->id}}">
												<h5 class="mb-0">
													<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$avaria->id}}" aria-expanded="false" aria-controls="collapse{{$avaria->id}}">
														Avaria {{ $avaria->id }} <!-- contar quantidade de avaria certo -->
													</button>
												</h5>
											</div>

											{{-- DIV PARA EXIBIR OS DADOS DA AVARIA --}}
											<div id="collapse{{$avaria->id}}" class="collapse" aria-labelledby="heading{{ $avaria->id }}" data-parent="#accordionInterno">
												<div class="card-body">
													{{-- SELECT LOCAL AVARIA --}}
													<div class="form-group">
        												<label for="localAvaria">Local da Avaria</label>
														<select class="MineSelect" name="localAvaria" id="localAvaria{{$avaria->id}}" ></select>
													</div>
													
													{{-- SELECT LOCAL AVARIA --}}
													<div class="form-group">
        												<label for="tipoAvaria">Tipo da Avaria</label>
														<select class="MineSelect" name="tipoAvaria" id="tipoAvaria{{$avaria->id}}"></select>
													</div>

													{{-- CAMPO OBSERVAÇÃO --}}
													<div class="form-group">
        												<label for="obs">Tipo da Avaria</label>
														<input class="form-control" type="text" value="{{ $avaria->obs }} " name="obs" id="obs">
													</div>
													
													{{-- BOTÃO PARA ENVIAR ATUALIZAÇÃO --}}
													<button type="submit" id="submit" class="btn btn-outline-primary"> Atualizar Avaria </button>
													<button type="submit" id="submit" class="btn btn-outline-primary" value="delete" style="padding-left: 32px; padding-right: 32px;"
														href="{{ route('descavarias.destroy', $avaria->id)  }}"
														onclick="event.preventDefault();
														document.getElementById('delete-avaria{{$avaria->id}}').submit();"> 
														<i class="fas fa-trash"></i> Excluir 
													</button>

									
													{{-- BOTÃO PARA DELETAR O DADO DA AVARIA --}}
													
    											</div>
    										</div>
										</div>
									</form>
									<form id="delete-avaria{{$avaria->id}}" method="POST" action="{{ route('descavarias.destroy', $avaria->id)  }}" enctype="multipart/form-data"> <!-- antes n tinha esse form. Era só o button uma linha abaixo. dai ficava lado a lado na tela. Era tudo post, ai usava um formaction na tag com o mesmo endereço do form de baixo. tentei formmethod pra n precisar de dois form mas foi não-->
										@method('delete')
										@csrf
									</form>
								@empty
									<h3>Nenhuma Avaria Cadastrada</h3>
								@endforelse
							</div> <!-- end acordion interno -->
					 	</div>
					</div>
				</div>  

				{{-- DIV PARA INSERIR NOVA AVARIA --}}
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
							{{-- INCLUDE DO CAMPO PARA INSERÇÃO DE DADOS --}}
            				@include('verificacao.novaVerificacao')

							<form method="POST" action="{{ route('descavarias.store', $verificacao->id) }}" enctype="multipart/form-data">
								@csrf

                				{{-- DIV PARA LISTAR O REGISTRO DE AVARIAS --}}
								<div id="divRegistroAvarias"></div>

								{{-- BOTÃO PARA SUBMETER --}}
								<button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Cadastrar nova avaria </button>
							</form>
						</div>
					</div>
				</div>
			</div>
			</div>	
		</div>
	</div>
@endsection