@extends('entrada.exibir')

@section('footer')
	<script type="text/javascript">
		var metodos;
	 	window.onload = function(){
		    @php
		        echo "
		            metodos = new Metodos('". csrf_token() ."');
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

	<div id="divMsg"></div>
	<div id="formFooter">
	    <div class="d-flex justify-content-center">
	        {{ $entradas->links() }}
	    </div>
	</div>
@endsection 
