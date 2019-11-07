@extends('layouts.app')
@section('content')
    <script src="{{ asset('js/jquery.min.js') }}" ></script>
    <script src="{{ asset('js/xzoom.min.js') }}" ></script>
    <script type="text/javascript">
        var avaria, fotos, metodos;    
        window.onload = function(){
            @php
                echo "
                    metodos = new Metodos('metodos', '". csrf_token() ."');
                    avaria = new Avaria('avaria', '". csrf_token() ."', '". $local_avarias ."', '" . $tipo_avarias . "');
                    avaria.carousel('divExibebeImagens', 'modalImg', '". $fotos ."'); 
                ";
            @endphp

            jQuery(function($) {
                $(".xzoom").xzoom({
                    position: 'right',
                    Xoffset: 15
                });
            });
        }
    </script>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Entrada</h3>
        @include('layouts.messages')
        <hr>
        <form method="POST" action="{{ route('entrada.store') }}" enctype="multipart/form-data">
            @csrf 
              
            <div class="container" id="divExibebeImagens"></div>
            <div id="modalImg"></div>

            <div class="form-group">
        		<label for="motorista">Motorista</label>
                <select class="MineSelect" name="motorista" required>
                    <option value="false"> Selecione um motorista</option>
                    @foreach($motorista as $Motorista) 
                        <option value="{{ $Motorista->id }}"> {{ $Motorista->nome }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
        		<label for="carro">Carro</label>
                <select class="MineSelect" name="carro" required> <!--tava form-control -->
                    <option value="false"> Selecione um carro</option>
                    @foreach($carro as $Carro)
                        <option value="{{ $Carro->id }}"> {{ $Carro->nome }} - {{ $Carro->placa }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
        		<label for="data">Data da Entrada</label>
                <input type="date" placeholder="Data" name="data" class="form-control" required>
            </div>
            <div class="form-group">
        		<label for="horario">Hora da Entrada</label>
                <input type="time" placeholder="Horário" name="horario" class="form-control" required>
            </div>
            <div class="form-group">
        		<label for="foto">Fotos</label>
                <input type="file" aria-label="foto" id="foto" name="fotos[]" class="form-control" accept="image/x-png, image/gif, image/jpeg, image/jpg" multiple required />
            </div>
            
            <div id="formFooter">
              <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>
        </form>
    </div>
</div>

  

@endsection