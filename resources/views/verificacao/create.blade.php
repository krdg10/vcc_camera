@extends('layouts.app')

@section('content')
<script type="text/javascript">
    var avaria, fotos;    
    var cont = 0;
    var metodos;

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

        $('#addAvaria').click(function(){
            var local = $('#localAvaria').val();
            var tipo = $('#tipoAvaria').val();
            var obs = $('#observacao').val();
        
            // VERIFICA SE O TIPO E LOCAL DE AVARIA FORAM PREENCHIDOS
            if (local == 'false' || tipo == 'false')
                return alert('Selecione local e tipo.');

            // PROCURA PELO VALOR DO LOCAL DA AVARIA
            var localString = 'Nada';
            for (var x = 0; x < localAvarias.length; x++)
                if(localAvarias[x].id == local){
                    localString = localAvarias[x].local;
                    break;
                }
            
            // PROCURA PELO VALOR DO TIPO DE AVARIA
            var tipoString = 'Nada';
            for (var w = 0; w < tipoAvarias.length; w++)
                if(tipoAvarias[w].id == tipoString){
                    tipoString = tipoAvarias[w].tipo;
                    break;
                }
            
            var text = '';
            if(local && tipo){
                avarias.push({ 'id': cont, 'loc': local, 'tip': tipo, 'ob': obs });
                cont++;
            }

            for(i in avarias){
                text += ' <span id="'+avarias[i].id+'" class="badge badge-primary badge-pill">'+ localString +' - '+tipoString+' - '+avarias[i].ob+' <input type="text" value="'+avarias[i].loc+'" name="local[]" class="d-none"> <input type="text" value="'+avarias[i].tip+'" name="tipo[]" class="d-none"> <input type="text" value="'+avarias[i].ob+'" name="obs[]" class="d-none">  <a id="excluir" onClick="excluir(`'+avarias[i].id+'`)"><i class="fa fa-times" aria-hidden="true"></i></a> </span>'
            }
            document.getElementById('avarias').innerHTML = text;
        })
    }

    function excluir(id){
        var remove = -1
        for(i in avarias){
            if(id == avarias[i].id){
                avarias.splice(i, 1);
                break;
            }
        }
        var text = ''
        for(i in avarias){
            text += ' <span id="'+avarias[i].id+'" class="badge badge-primary badge-pill">'+avarias[i].loc+' - '+avarias[i].tip+' - '+avarias[i].ob+' <input type="text" value="'+avarias[i].loc+'" name="local[]" class="d-none"> <input type="text" value="'+avarias[i].tip+'" name="tipo[]" class="d-none"> <input type="text" value="'+avarias[i].obs+'" name="obs[]" class="d-none"> <a id="excluir" onClick="excluir(`'+avarias[i].id+'`)"><i class="fa fa-times" aria-hidden="true"></i></a> </span>'
        }
        element = document.getElementById('avarias')
        element.innerHTML = text
    }
</script>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Verificar entrada</h3>
        {{-- EXIBE MENSAGEM DE SUCESSO. --}}
        @if( \Session::has('error') )
            @foreach(session()->get('error') as $key => $ms)
                <span id="{{ $key }}error" class="badge badge-danger badge-pill">
                    {{ $ms }}
                    <a id="excluir" onClick="excluirElement('{{ $key }}error')"><i class="fa fa-times" aria-hidden="true"></i></a>
                </span>
            @endforeach
        @endif
        @if( \Session::has('message') )
            <span id="success" class="badge badge-success badge-pill">
                {{ \Session::get('message') }}
                    <a id="excluir" onClick="excluirElement('success')"><i class="fa fa-times" aria-hidden="true"></i></a>
            </span>
        @endif

        {{-- DIV PARA EXIBIR MENSAGENS --}}
        <div id="divMsg"></div>

        <div class="form-control"  style="height: 120px">
            <h5>Motorista: {{$entradas->motorista->nome}}</h5>
            <h5>Carro: {{$entradas->carro->nome}} - {{$entradas->carro->placa}}</h5>
        </div>

        {{-- DIV QUE EXIBE OS DADOS DA ENTRADA --}}
        <div id="divExibebeImagens" class="form-control"  style="height: 400px">
            {{-- <div>
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($entradas->fotos as $fotos)
                        <div class="carousel-item">
                        <div class="carousel-item active">
                          <img class="d-block w-100" src="{{url('/storage/'.$fotos->path)}}" alt="Slide Secundário">
                        </div>
                    @endforeach

                </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </div>
            </div> --}}
        </div>
        

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
                    <div id="btnObs"><button id="addAvaria" type="button" class="btn btn-outline-primary">+</button></div>
                </div>

                {{-- DIV PARA LISTAR AS VERIFICAÇÕES --}}
                <div id="avarias"></div>

                <div id="formFooter">
                    {{-- <label>Verificado:</label><input type="checkbox" name="verificado" id="verificado" value="1" class="form-control" checked> --}}
                    <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Confirmar verificação </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
