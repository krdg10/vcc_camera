@extends('layouts.app')
@section('content')
	<script type="text/javascript">
	    var avaria;
	    var metodos, xhttp;

	    window.onload = function(){
	        @php
	            echo "
	                metodos = new Metodos('". csrf_token() ."');
	                avaria = new Avaria('{}', '". $tipo_avarias ."')
	            ";
	        @endphp
	    }
		
	</script>

	<div class="wrapper fadeInDown">
	    <div id="formContent">
			<h3>Lista de Tipos de Avaria</h3>
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
	        <div class="fadeIn first">
		        <table class="table table-hover table-striped">
	                <thead>
	                    <tr>
	                        <th>ID</th>
	                        <th>Tipo</th>
	                        <th>Ação</th>
	                    </tr>
	                </thead>

	                <tbody>
		        		@foreach ($tipo_avarias as $tipo_avaria)
	                        <tr>
	                            <td>{{$tipo_avaria->id}}</td>
	                            <td>{{$tipo_avaria->tipo}}</td>
	                            <td>
									<div class="p-2 iconesLista"><a data-toggle="modal" href="#editAvaria" data-target="#editAvaria" onclick="avaria.edit('tipo', {{$loop->iteration }} - 1, event)" >
											<i class="fas fa-edit"></i>
										</a>
									

	                            		<a href="/tipoAvaria" ><i class="fas fa-trash" onclick="metodos.xhttp.xmlHttpDelete('/tipoAvaria/{{$tipo_avaria->id}}')"></i></a>
									</div>
								</td>
	                        </tr>
	                    @endforeach
	                </tbody>
	            </table>
			</div>
			<div id="formFooter">
                <div class="d-flex justify-content-center">
                    <button data-toggle="modal" href="#modalCreateAvaria" data-target="#modalCreateAvaria" class="fadeIn fourth btn btn-primary">Adicionar Novo</button>
                </div>
            </div>
			
		</div>
	</div>

	@include('avaria.edit_tipoAvaria')
	@include('avaria.create_tipoAvaria')

@endsection 