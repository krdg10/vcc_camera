@extends('layouts.app')
@section('content')

	<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">

	        @foreach ($tipo_avarias as $tipo_avaria)
			    <div class="d-flex justify-content-center">
			        {{$tipo_avaria->tipo}}
			    </div>
	        @endforeach

        </div>
        
    </div>
</div>

@endsection 