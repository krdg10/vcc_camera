@extends('layouts.app')
@section('content')
<script>

    function excluirElement(id){
        $('#'+id).remove();
    }

    jQuery(function($) {
        $(".xzoom").xzoom({
            position: 'right',
            Xoffset: 15
        });
    });

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

    $(document).ready(function(){
        $('img')
            .wrap('<span style="display:inline-block"></span>')
            .css('display', 'block')
            .parent()
            .zoom();
    });
</script>
<script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h3>Cadastrar Entrada</h3>
        @include('layouts.messages')
        <hr>
        <form method="POST" action="{{ route('entrada.store') }}" enctype="multipart/form-data">
            @csrf   
           <!-- https://artisansweb.net/how-to-add-zoom-image-effect-on-your-website-images/-->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" id="container">
                        <!--                        <img class="d-block w-100" id="myImg" style="height: 300px" src="http://admin:vcc123456@192.168.1.65:64/Streaming/channels/2/picture" alt="Imagem da Câmera">-->
                        <img class="d-block w-100 /" id="myImg" style="height: 300px" src="http://localhost:8000/storage/fotos/1_store_rbt_40.jpg"   alt="Imagem da Câmera">
                    </div>
                </div>
            </div>
            <div id="modalImag" class="modal">

                <!-- The Close Button -->
                <span class="close">&times;</span>

                <!-- Modal Content (The Image) -->
                <img class="modal-content xzoom" id="img01" xoriginal="http://localhost:8000/storage/fotos/1_store_rbt_40.jpg">

                <!-- Modal Caption (Image Text) -->
                <div id="caption"></div>
            </div>

            <select class="MineSelect" name="motorista" required>
                <option value="false"> Selecione um motorista</option>
                @foreach($motorista as $Motorista) 
                    <option value="{{ $Motorista->id }}"> {{ $Motorista->nome }} </option>
                @endforeach
            </select>
            <select class="MineSelect" name="carro" required> <!--tava form-control -->
                <option value="false"> Selecione um carro</option>
                @foreach($carro as $Carro)
                    <option value="{{ $Carro->id }}"> {{ $Carro->nome }} - {{ $Carro->placa }} </option>
                @endforeach
            </select>

            <input type="date" placeholder="Data" name="data" class="form-control" required>
            <input type="time" placeholder="Horário" name="horario" class="form-control" required>
            <input type="file" aria-label="foto" id="foto" name="fotos[]" class="form-control" accept="image/x-png, image/gif, image/jpeg, image/jpg" multiple required />
            
            <div id="formFooter">
              <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
            </div>
        </form>
    </div>
</div>

  

   

@endsection
