<<<<<<< HEAD
@extends('layouts.app')
@section('content')
<script>
    var fotos = []
    var cont = 0
    window.onload = function(){
        $('#addfoto').click(function(){
            var foto = $('#foto').val()
            var text = ''
            if(foto){
                fotos.push({ 'id': cont, 'conteudo': foto })
                cont++
                console.log(fotos)
            }
            for(i in fotos){
                text += ' <span id="'+fotos[i].id+'" class="badge badge-primary badge-pill">'+fotos[i].conteudo+'<input type="text" value="'+fotos[i].conteudo+'" name="foto[]" class="d-none">  <a id="excluir" onClick="excluir(`'+fotos[i].id+'`)"><i class="fa fa-times" aria-hidden="true"></i></a> </span>'
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
            text += ' <span id="'+fotos[i].id+'" class="badge badge-primary badge-pill">'+fotos[i].conteudo+' <input type="text" value="'+fotos[i].conteudo+'" name="foto[]" class="d-none"> <a id="excluir" onClick="excluir(`'+fotos[i].id+'`)"><i class="fa fa-times" aria-hidden="true"></i></a> </span>' 
        }
        element = document.getElementById('fotos')
        element.innerHTML = text
    }
    function excluirElement(id){
        $('#'+id).remove();
    }
</script>
<!-- onde tava type=time no text+= tava dando BO com file e coloquei type=text -->
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
        <li class="list-group-item">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Foto</span>
                </div>
                <input type="file" aria-label="foto" id="foto" class="form-control">
                               
                <div class="input-group-append">
                    <button type="button" id="addfoto" class="btn btn-outline-success"> Adicionar </button>
                </div>
            </div>
            <div class="text-right">
                <span class="badge badge-secondary badge-pill">Coloque as imagens dos ônibus.</span>
            </div>
            <div class="text-right">
                <span class="badge badge-danger badge-pill">Cuidado para inserir as imagens corretas.</span>
            </div>
            <div id="fotos"> </div>
        </li>
        <button type="submit" id="submit" class="btn btn-outline-success"> Salvar </button>
    </form>
</div>

  

   

@endsection
