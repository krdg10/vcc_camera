@extends('layouts.app')
@section('content')
<script> 
    function excluirElement(id){
        $('#'+id).remove();
    }
</script>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Entrada</h3>
        {{-- Exibe mensagem de sucesso ou de erro caso haja. --}}
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


        
        <hr>
        <form method="POST" action="{{ route('entrada.store') }}" enctype="multipart/form-data">
            @csrf
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" id="myImg" style="height: 300px" src="http://192.168.254.193:94/snapshot.cgi?user=lan&pwd=lan&t=" alt="Imagem da Câmera">
                    </div>
                </div>
            </div>
            <div id="modalImag" class="modal">

                <!-- The Close Button -->
                <span class="close">&times;</span>

                <!-- Modal Content (The Image) -->
                <img class="modal-content" id="img01">

                <!-- Modal Caption (Image Text) -->
                <div id="caption"></div>
            </div>
            <script>
                // Get the modal
                var modal = document.getElementById("modalImag");

                // Get the image and insert it inside the modal - use its "alt" text as a caption
                var img = document.getElementById("myImg");
                var modalImg = document.getElementById("img01");
                var captionText = document.getElementById("caption");
                img.onclick = function(){
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
                }

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() { 
                modal.style.display = "none";
                }
            </script>


            <select class="MineSelect" name="motorista">
                <option value="false"> Selecione um motorista</option>
                @foreach($motorista as $Motorista) 
                    <option value="{{ $Motorista->id }}"> {{ $Motorista->nome }} </option>
                @endforeach
            </select>
            <select class="MineSelect" name="carro"> <!--tava form-control -->
                <option value="false"> Selecione um carro</option>
                @foreach($carro as $Carro)
                    <option value="{{ $Carro->id }}"> {{ $Carro->nome }} - {{ $Carro->placa }} </option>
                @endforeach
            </select>

            <input type="datetime-local" placeholder="Horário" name="horario" class="form-control">
            <input type="file" aria-label="foto" id="foto" name="fotos[]" class="form-control" multiple />
            
            <div id="formFooter">
              <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>
        </form>
    </div>
</div>

  

   

@endsection
