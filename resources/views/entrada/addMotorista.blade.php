@extends('layouts.app')
@section('content')
    <div class="wrapper fadeInDown">
        <script type="text/javascript">
            var avaria, fotos, metodos;    

            window.onload = function(){
                @php
                    echo "
                        metodos = new Metodos('metodos', '". csrf_token() ."');
                        avaria = new Avaria('avaria', '". csrf_token() ."');
                        avaria.carousel('divExibebeImagens', 'modalImg', '". $fotos ."'); 
                    ";
                @endphp
            }
        </script>

        <div id="formContent">	
            <h3>Entrada</h3> <hr>

            @include('layouts.messages')

            {{-- DIV PARA EXIBIR AS IMAGENS --}}
            <div class="container" id="divExibebeImagens"></div>

            {{-- MODAL DA IMAGEM --}}
            <div id="modalImg"></div>

            {{-- DIV QUE EXIBE OS DADOS DA ENTRADA --}}
            <div class="container">
                <form method="POST" action="{{ route('entrada.adicionaMotorista', $entrada->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <select class="MineSelect" name="motorista" required>
                        <option value="false"> Adicione um motorista</option>
                        @foreach($motorista as $Motorista) 
                            <option value="{{ $Motorista->id }}"> {{ $Motorista->nome }} </option>
                        @endforeach
                    </select>
                    <input type="text" placeholder="Veículo" name="veiculo" class="form-control" value="{{ $entrada->carro->nome }} - {{ $entrada->carro->placa }}" disabled>
                    <div id="formFooter">
                        <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
                    </div>	
                </form>			
            </div>
        </div>
    </div>
@endsection
