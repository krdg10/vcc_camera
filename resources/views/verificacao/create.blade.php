@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        var avaria, fotos, metodos;

        window.onload = function(){
            @php
                echo "
                    metodos = new Metodos('". csrf_token() ."');
                    avaria = new Avaria('avaria',  '". csrf_token() ."', '". $localAvarias ."', '" . $tipoAvarias . "'); 
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
        $("#modalImg").click(function(){
        $(".modal").addClass("visible");
        });

        $(".close").click(function(){
        $(".modal").removeClass("visible");
        });

        $(document).click(function(event) {
        //if you click on anything except the modal itself or the "open modal" link, close the modal
        if (!$(event.target).closest(".modal,#modalImg").length) {
            $("body").find(".modal").removeClass("visible");
        }
        });

    </script>

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h3>Verificar entrada</h3> <hr>

            {{-- DIV PARA EXIBIR MENSAGENS --}}
            <div id="divMsg"></div>

            {{-- MODAL DA IMAGEM --}}
            <div id="modalImg"></div>

            {{-- DIV QUE EXIBE OS DADOS DA ENTRADA --}}
            <div class="container">
                <h5>Motorista: @empty($entrada->motorista->nome)-@endempty @isset($entrada->motorista->nome){{$entrada->motorista->nome}}@endisset</h5>
                <h5>Carro: {{$entradas->carro->nome}} - {{$entradas->carro->placa}}</h5>
            </div>

            {{-- DIV PARA EXIBIR AS IMAGENS --}}
            <div id="divExibebeImagens" class="container"></div>
            
            <div class="container" style="padding-left: 0px; padding-right:0px;">
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
