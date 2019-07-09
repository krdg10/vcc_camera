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
	                            	<a data-toggle="modal" href="#editAvaria" data-target="#editAvaria" onclick="avaria.edit('tipo', {{$loop->iteration }} - 1, event)" >
	                            		<i class="fas fa-edit"></i>
	                            	</a>

	                            	<a href="/tipoAvaria" ><i class="fas fa-trash" onclick="metodos.xhttp.xmlHttpDelete('/tipoAvaria/{{$tipo_avaria->id}}')"></i></a>
	                            </td>
	                        </tr>
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
		</div>
	</div>

	@include('avaria.edit')

@endsection 