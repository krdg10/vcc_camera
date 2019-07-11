@extends('layouts.app')
@section('content')
	<script type="text/javascript">
	    var avaria;
	    var metodos, xhttp;

	    window.onload = function(){
	        @php
	            echo "
	                metodos = new Metodos('". csrf_token() ."');
	                avaria = new Avaria('{}', '". $local_avarias ."')
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
		        		@foreach ($local_avarias as $local_avaria)
	                        <tr>
	                            <td>{{$local_avaria->id}}</td>
	                            <td>{{$local_avaria->local}}</td>
	                            <td>
									<div class="p-2 iconesLista"><a data-toggle="modal" href="#editAvaria" data-target="#editAvaria" onclick="avaria.edit('local', {{$loop->iteration }} - 1, event)" >
											<i class="fas fa-edit"></i>
										</a>
									

	                            		<a href="/localAvaria" ><i class="fas fa-trash" onclick="metodos.xhttp.xmlHttpDelete('/localAvaria/{{$local_avaria->id}}')"></i></a>
									</div>
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