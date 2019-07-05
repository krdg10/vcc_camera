@extends('layouts.app')

@section('content')
<script type="text/javascript">
    var avaria, fotos, metodos;
    var cont = 0;

    window.onload = function(){
        @php
            echo "
                metodos = new Metodos('". csrf_token() ."');
                avaria = new Avaria('". $localAvarias ."', '" . $tipoAvarias . "'); 
                fotos = JSON.parse('". $entradas->fotos ."');
            ";
        @endphp

        // FUNÇÃO PARA SETAR O OPTION EM SELECT DAS AVARIAS
        avaria.setSelect('localAvaria', 'local');
        avaria.setSelect('tipoAvaria', 'tipo'); 
        avaria.carousel('divExibebeImagens', fotos)

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

        <div class="form-control"  style="height: 120px">
            <h5>Motorista: {{$entradas->motorista->nome}}</h5>
            <h5>Carro: {{$entradas->carro->nome}} - {{$entradas->carro->placa}}</h5>
        </div>

        {{-- DIV QUE EXIBE OS DADOS DA ENTRADA --}}
        <div id="divExibebeImagens" class="form-control"  style="height: 400px"></div>
        
        <div>
            <form method="POST" action="{{ route('verificacao.store', $entradas->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <h4 style="margin-top: 0.5rem">Inserir Avaria (Caso Haja)</h4>
                {{-- SELECT LOCAL AVARIA --}}
                <select class="MineSelect" name="localAvaria" id="localAvaria" onchange="avaria.storeAVaria(this, 'local', 0, '/localAvaria')"></select>

                {{-- SELECT TIPO DE AVARIA --}}
                <select class="MineSelect" name="tipoAvaria" id="tipoAvaria" onchange="avaria.storeAVaria(this, 'tipo', 1, '/tipoAvaria')"></select>

                <div id="addObs" class="row" >
                    {{-- DIV CAMPO OBSERVAÇÃO --}}
                    <div class="col-sm-9 col-md-6 col-lg-8" style="flex: 0 0 76.666667%; max-width: 86.666667%;">
                        <textarea placeholder="Observação" name="observacao" id="observacao"></textarea>
                    </div>
                    
                    {{-- BUTTON PARA ADICIONAR NOVA VERIFICAÇÃO --}}
                    <div id="btnObs"><button type="button" class="btn btn-outline-primary" onclick="avaria.setRegistrarVerificacao('localAvaria', 'tipoAvaria', 'observacao', 'divRegistroAvarias')">+</button></div>
                </div>

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
