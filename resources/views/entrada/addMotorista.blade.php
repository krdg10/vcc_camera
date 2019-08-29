@extends('layouts.app')
@section('content')
    <div class="wrapper fadeInDown">
        <script type="text/javascript">
            var avaria, fotos, metodos;    

            window.onload = function(){
                @php
                    echo "
                        metodos = new Metodos('metodos', '". csrf_token() ."');
                        avaria.carousel('divExibebeImagens', 'modalImg', '". $fotos ."'); 
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

        <div id="formContent">	
            <h3>Entrada</h3> <hr>

            {{-- DIV PARA EXIBIR MENSAGENS --}}
            <div id="divMsg"></div>

            {{-- DIV QUE EXIBE OS DADOS DA ENTRADA --}}
            <div class="container">
                <form method="POST" action="{{ route('entrada.adicionaMotorista', $entrada->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <select class="MineSelect" name="motorista">
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