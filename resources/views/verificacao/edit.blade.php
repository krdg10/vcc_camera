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
	                avaria = new Avaria('avaria', '". $local_avarias ."', '" . $tipo_avarias . "'); 
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


	<div class="wrapper fadeInDown">
	    <div id="formContent">
		    <h3>Verificar entrada</h3>

		    {{-- DIV PARA EXIBIR MENSAGENS --}}
		    <div id="divMsg"></div>

            {{-- MODAL DA IMAGEM --}}
            <div id="modalImg"></div>

	        {{-- EXIBE OS DADOS DO MOTORISTA --}}
	        <div class="form-control"  style="height: 120px">
	            <h5>Motorista: {{$entradas->motorista->nome}}</h5>
	            <h5>Carro: {{$entradas->carro->nome}} - {{$entradas->carro->placa}}</h5>
	        </div>
	       
       		{{-- DIV PARA EXIBIR AS IMAGENS --}}
			<div class="form-control" id="divExibebeImagens" style="height: 400px"></div>

			{{-- VISUALIZAR OS CAMPO PARA EDITAR E ATUALIZAR --}}
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
												 	<select class="MineSelect" name="localAvaria" id="localAvaria{{$avaria->id}}" ></select>
													
													{{-- SELECT LOCAL AVARIA --}}
													<select class="MineSelect" name="tipoAvaria" id="tipoAvaria{{$avaria->id}}"></select>

													{{-- CAMPO OBSERVAÇÃO --}}
													<input class="form-control" type="text" value="{{ $avaria->obs }} " name="obs" id="obs">
													
													{{-- BOTÃO PARA ENVIAR ATUALIZAÇÃO --}}
													<button type="submit" id="submit" class="btn btn-outline-primary"> Atualizar Avaria </button>
													
									</form>
													{{-- BOTÃO PARA DELETAR O DADO DA AVARIA --}}
													<form method="POST" action="{{ route('descavarias.destroy', $avaria->id)  }}" enctype="multipart/form-data"> <!-- antes n tinha esse form. Era só o button uma linha abaixo. dai ficava lado a lado na tela. Era tudo post, ai usava um formaction na tag com o mesmo endereço do form de baixo. tentei formmethod pra n precisar de dois form mas foi não-->
														<button type="submit" id="submit" class="btn btn-outline-primary" value="delete" style="padding-left: 32px; padding-right: 32px; margin-top: 5px;"> <i class="fas fa-trash"></i> Excluir </button>
														@method('delete')
														@csrf
													</form>
    											</div>
    										</div>
    									</div>
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
            				@include('verificacao/novaVerificacao')

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
@endsection