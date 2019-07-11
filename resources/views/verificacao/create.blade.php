@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        var avaria, fotos, metodos;

        window.onload = function(){
            @php
                echo "
                    metodos = new Metodos('". csrf_token() ."');
                    avaria = new Avaria('avaria', '". $localAvarias ."', '" . $tipoAvarias . "'); 
                    fotos = '". $entradas->fotos ."';
                ";
            @endphp

            // FUNÇÃO PARA SETAR O OPTION EM SELECT DAS AVARIAS
            avaria.setSelect('localAvariaNovo', 'local');
            avaria.setSelect('tipoAvariaNovo', 'tipo'); 
            avaria.carousel('divExibebeImagens', 'modalImg', fotos);

            // EXIBE MENSAGEM DE SUCESSO.
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

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h3>Verificar entrada</h3>

            {{-- DIV PARA EXIBIR MENSAGENS --}}
            <div id="divMsg"></div>

            {{-- MODAL DA IMAGEM --}}
            <div id="modalImg"></div>

            {{-- DIV QUE EXIBE OS DADOS DA ENTRADA --}}
            <div class="form-control"  style="height: 120px">
                <h5>Motorista: {{$entradas->motorista->nome}}</h5>
                <h5>Carro: {{$entradas->carro->nome}} - {{$entradas->carro->placa}}</h5>
            </div>

            {{-- DIV PARA EXIBIR AS IMAGENS --}}
            <div id="divExibebeImagens" class="form-control"  style="height: 400px"></div>
            
            <div>
                {{-- INCLUDE DO CAMPO PARA INSERÇÃO DE DADOS --}}
                @include('verificacao/novaVerificacao')

                <form method="POST" action="{{ route('verificacao.store', $entradas->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{-- DIV PARA LISTAR O REGISTRO DE AVARIAS --}}
                    <div id="divRegistroAvarias"></div>

                    <div id="formFooter">
                        <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Confirmar verificação </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
