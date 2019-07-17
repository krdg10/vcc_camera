@extends('layouts.app')
@section('content')
	<script type="text/javascript">
	    var avaria;
	    var metodos, xhttp;

	    window.onload = function(){
	        @php
	            echo "
	                metodos = new Metodos('". csrf_token() ."');
	                avaria = new Avaria('avaria', '". csrf_token() ."', '". $avarias ."', '". $avarias ."');
	            ";
	        @endphp

            // EXIBE MENSAGEM DE SUCESSO.
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
			<h3>Lista {{$chave}} avaria</h3>

            {{-- DIV PARA EXIBIR MENSAGENS --}}
            <div id="divMsg"></div>

	        <div class="fadeIn first">
		        <table class="table table-hover table-striped">
	                <thead>
	                    <tr>
	                        <th>ID</th>
	                        <th>{{$chave}}</th>
	                        <th>Ação</th>
	                    </tr>
	                </thead>

	                <tbody id="tbodyIndex">
		        		@foreach ($avarias as $avaria)
	                        <tr>
	                            <td>{{$avaria->id}}</td>
	                            <td id="{{$chave . $avaria->id}}">{{$avaria[$chave]}}</td>
	                            <td>
									<div class="p-2 iconesLista"><a data-toggle="modal" href="#editAvaria" data-target="#editAvaria" onclick="avaria.edit('{{$chave}}', {{$loop->iteration }} - 1)" >
											<i class="fas fa-edit"></i>
										</a>

	                            		<a href="" >
	                            			<i class="fas fa-trash" onclick="metodos.xhttp.xmlHttpDelete('/{{$chave}}Avaria/{{$avaria->id}}')"></i>
	                            		</a>
									</div>
								</td>
	                        </tr>
	                    @endforeach
	                </tbody>
	            </table>
			</div>

			{{-- BOTÃO PARA INSERIR NOVA AVÁRIA --}}
			<div id="formFooter">
                <div class="d-flex justify-content-center">
                    <button data-toggle="modal" href="#modalCreateAvaria" data-target="#modalCreateAvaria" class="fadeIn fourth btn btn-primary">Adicionar Novo</button>
                </div>
            </div>
			
		</div>
	</div>

	@include('avaria.edit')
	@include('avaria.create')

@endsection 