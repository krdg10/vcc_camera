@extends('layouts.app')
@section('content')
<script>
    var fotos = []
    var cont = 0
    window.onload = function(){
        $('#addfoto').click(function(){
            var path = $('#foto').val()
            var text = ''
            if(foto){
                fotos.push({ 'id': cont, 'foto': path })
                cont++
                console.log(fotos)
            }
            for(i in fotos){
                text += ' <span id="'+fotos[i].id+'" class="badge badge-primary badge-pill">'+fotos[i].path+' <input type="file" value="'+fotos[i].path+'" name="path[]" class="d-none">  <a id="excluir" onClick="excluir(`'+fotos[i].id+'`)"><i class="fa fa-times" aria-hidden="true"></i></a> </span>'
            }
            element = document.getElementById('fotos')
            element.innerHTML = text
        })
    }
    function excluir(id){
        var remove = -1
        for(i in fotos){
            if(id == fotos[i].id){
                fotos.splice(i, 1);
                break;
            }
        }
        var text = ''
        for(i in fotos){
            text += ' <span id="'+fotos[i].id+'" class="badge badge-primary badge-pill">'+fotos[i].path+' <input type="time" value="'+fotos[i].path+'" name="inicio[]" class="d-none">  <a id="excluir" onClick="excluir(`'+fotos[i].id+'`)"><i class="fa fa-times" aria-hidden="true"></i></a> </span>'
        }
        element = document.getElementById('fotos')
        element.innerHTML = text
    }
    function excluirElement(id){
        $('#'+id).remove();
    }
</script>

<div id="formContent">
    <form method="POST" action="{{ route('entrada.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
        <select class="formControl" name="motorista">
            @foreach($motorista as $Motorista) 
                <option value="{{ $Motorista->id }}"> {{ $Motorista->nome }} </option>
            @endforeach
        </select>
        <select class="formControl" name="carro">
            @foreach($carro as $Carro)
                <option value="{{ $Carro->id }}"> {{ $Carro->nome }} - {{ $Carro->placa }} </option>
            @endforeach
        </select>

        <input type="datetime-local" placeholder="Horário" name="horario" class="form-control">
       
        <button type="submit" id="submit" class="btn btn-outline-success"> Salvar </button>

    </form>
    <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Expediente</span>
                                </div>
                                <input type="file" aria-label="Começo" id="foto" class="form-control">
                                
                                <div class="input-group-append">
                                    <button type="button" id="addfoto" class="btn btn-outline-success"> Adicionar </button>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-secondary badge-pill">Coloque aqui seu expediente, seja sensato</span>
                                <span class="badge badge-secondary badge-pill">Só coloque o horário que estiver disponível</span>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-danger badge-pill">Não coloque no seu expediente o horário de alguma aula que está frequentando</span>
                            </div>
                            <div id="fotos"> </div>
                        </li>
</div>
@endsection
