@extends('layouts.app')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
    	{{-- VERIFICA SE EXISTE O ID NA URL --}}
    	@if (isset($_GET['id']))
		    <h3>Verificar entrada</h3> <hr>

			<form method="post" action="/verificacoa">
		    	{{ csrf_field() }}

				{{-- LOCAL DA AVARIA --}}
				<select class="form-control" name="localAvaria">
					<option value="false">Selecione o local</option>
					@for ($i = 0; $i < $localAvarias->count(); $i++)
						<option value="{{$localAvarias[$i]->id}}">{{$localAvarias[$i]->local}}</option>
					@endfor
				</select>

				{{-- TIPO DE AVARIA --}}
				<select class="form-control" name="tipoAvaria">
					<option value="false">Selecione o tipo</option>
					@for ($i = 0; $i < $tipoAvarias->count(); $i++)
						<option value="{{$tipoAvarias[$i]->id}}">{{$tipoAvarias[$i]->local}}</option>
					@endfor
				</select>
		        <input type="textArea" placeholder="Observação" name="observacao" class="form-control">

		        <div id="formFooter">
		            <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
		        </div>
			</form>

    		
    	@else
    		<img src="https://thumbs.dreamstime.com/t/face-amarela-feliz-do-sorriso-2810683.jpg">
    	@endif
	</div>
</div>
@endsection
