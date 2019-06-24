@extends('layouts.app')

@section('content')<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Verificar entrada</h3> <hr>

		<form>
        	{{ csrf_field() }}
			
		</form>
		</div>
	</div>
@endsection
