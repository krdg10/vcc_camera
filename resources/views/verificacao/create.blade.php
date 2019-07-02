@extends('layouts.app')

@section('content')
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
        <div id="divMsg"></div>
        <div class="form-control"  style="height: 400px">
            {{-- DIV QUE EXIBE OS DADOS DA ENTRADA --}}
            <div>
                @php 
                    $tester=1;
                @endphp
                <h5>Motorista: {{$entradas->motorista->nome}}</h5>
                <h5>Carro: {{$entradas->carro->nome}} - {{$entradas->carro->placa}}</h5>

                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($entradas->fotos as $fotos)
                        @if($tester==1)
                        <div class="carousel-item active">
                          <img class="d-block w-100" style="height: 300px" src="{{url('/storage/'.$fotos->path)}}" alt="Primeiro Slide">
                        </div>
                            @php
                                $tester=2;
                            @endphp
                        @else
                        <div class="carousel-item">
                          <img class="d-block w-100" style="height: 300px" src="{{url('/storage/'.$fotos->path)}}" alt="Slide Secundário">
                        </div>
                        @endif
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
            </div>
        </div>
        

        <div>
        <form method="POST" action="{{ route('verificacao.store', $entradas->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <h4 style="margin-top: 0.5rem">Inserir Avaria (Caso Haja)</h4>
            {{-- SELECT LOCAL AVARIA --}}
            {{-- <select class="MineSelect" name="localAvaria" id="localAvaria" onchange="storeLocalAVaria(this)"></select> --}}
            <select class="MineSelect" name="localAvaria" id="localAvaria" onchange="storeAVaria(this, 'local', 0, '/localAvaria')"></select>

            {{-- SELECT TIPO DE AVARIA --}}
            {{-- <select class="MineSelect" name="tipoAvaria" id="tipoAvaria" onchange="storeTipoAVaria(this)"></select> --}}
            <select class="MineSelect" name="tipoAvaria" id="tipoAvaria" onchange="storeAVaria(this, 'tipo', 1, '/tipoAvaria')"></select>

            {{-- DIV CAMPO OBSERVAÇÃO --}}
            <div id="addObs" class="row" >

            {{-- <input type="text" placeholder="Observação" name="observacao" id="observacao" class="form-control"> --}}
            <div class="col-sm-9 col-md-6 col-lg-8" style="flex: 0 0 76.666667%; max-width: 86.666667%;"><textarea placeholder="Observação" name="observacao" id="observacao"></textarea></div>
                
            <div id="btnObs"><button id="addAvaria" type="button" class="btn btn-outline-primary">+</button></div>
            </div>
            <div id="avarias"></div>

                <div id="formFooter">
                    <!--<div id="marcaCheck">
                        <label>Verificado:</label><input type="checkbox" name="verificado" id="verificado" value="1" class="form-control" checked>
                    </div>-->
                    <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Confirmar verificação </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var localAvarias, tipoAvarias;
    var avarias = new Array();
    @php
        echo "localAvarias = JSON.parse('" . $localAvarias . "');";
        echo "tipoAvarias = JSON.parse('" . $tipoAvarias . "');";
    @endphp
    avarias.push(localAvarias, tipoAvarias);

    var cont = 0;
    var metodos;

    window.onload = function(){
    metodos = new Metodos("{{ csrf_token() }}");

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

        // FUNÇÃO PARA SETAR O OPTION EM SELECT DAS AVARIAS
        setSelect('localAvaria', localAvarias, 'local', 'Selecione o local da avaria');
        setSelect('tipoAvaria', tipoAvarias, 'tipo', 'Selecione o tipo da avaria'); 
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

    function storeLocalAVaria(selectAvaria){
        var obj = this;
        // VERIFICA SE O VALOR NOVO FOI SELECIONADO
        if (selectAvaria.value != 'novo') return false;

        var localAVariaTxt = prompt ("Inserir novo local avaria");

        // VERIFICA SE O CAMPO ESTA VAZIO
        if(localAVariaTxt == '' || localAVariaTxt == null){
            metodos.msgSuccess("Nenhum valor inserido.");
            return false;
        }

        metodos.post([{'local':localAVariaTxt}], '/localAvaria', function(r){
            if (r.tipo == 1){
                obj.localAvarias.push(r.dados);
                setSelect(selectAvaria.id, obj.localAvarias, 'local', 'Selecione o local da avaria'); 
            }

            metodos.msgSuccess(r.msg)
        });
    }        
    function storeAVaria(select, msg, pos, url){
        // VERIFICA SE O VALOR NOVO FOI SELECIONADO
        if (select.value != 'novo') return false;

        var valor = prompt ("Inserir novo "+ msg +" avaria");

        // VERIFICA SE O CAMPO ESTA VAZIO
        if(valor == '' || valor == null){
            alert("Nenhum valor inserido.");
            return false;
        }

        var json = JSON.parse('[{"'+ msg +'":"'+ valor +'"}]');
        metodos.post(json, url, function(r){
            if (r.tipo == 1){
                avarias[pos].push(r.dados);
                console.log(r.dados);
                setSelect(select.id, avarias[pos], msg, 'Selecione o '+ msg +' da avaria'); 
            }

            metodos.msgSuccess(r.msg)
        });
    }

    function storeTipoAVaria(selectAvaria){
        // VERIFICA SE O VALOR NOVO FOI SELECIONADO
        if (selectAvaria.value != 'novo') return false;

        var tipoAVariaTxt = prompt ("Inserir novo tipo avaria");

        // VERIFICA SE O CAMPO ESTA VAZIO
        if(tipoAVariaTxt == '' || tipoAVariaTxt == null){
            alert("Nenhum valor inserido.");
            return false;
        }

        metodos.post([{'tipo':localAVariaTxt}], '/tipoAvaria', function(r){
            if (r.tipo == 1){
               tipoAvarias.push(retorno.dados);
                setSelect(selectAvaria.id, tipoAvarias, 'tipo', 'Selecione o tipo da avaria'); 
            }

            metodos.msgSuccess(r.msg)
        });
    }

    // FUNÇÃO PARA CRIAR AS OPTION SETAR NA SELECT
    function setSelect(id, array, chave, msg, novo=true){
        var option = '<option value="false">'+ msg +'</option>';
        for (var i = 0; i < array.length; i++) 
            option = option + `<option value="`+ array[i].id +`">`+ array[i][chave] +`</option>`

        // CASO NÃO QUEIRA CAMPO PARA REGISTRAR NOVO TIPO OU LOCAL
        if (novo) 
            option = option + `<option value="novo">Novo tipo de avaria</option>`;

        document.getElementById(id).innerHTML = option;
    }
</script>
@endsection
