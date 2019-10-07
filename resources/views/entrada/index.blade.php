@extends('entrada.exibir')

@section('search')
	<script type="text/javascript">
		var metodos;
	 	window.onload = function(){
		    @php
		        echo "
		            metodos = new Metodos('". csrf_token() ."');
		        ";
		    @endphp
		}
	</script>

	@include('layouts.messages')
@endsection
@section('footer')
	<div id="formFooter">
	    <div class="d-flex justify-content-center">
	        {{ $entradas->onEachSide(1)->links() }}
	    </div>
	</div>
@endsection 
