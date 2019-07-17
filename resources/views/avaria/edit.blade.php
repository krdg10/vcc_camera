<div class="modal fade" id="editAvaria" tabindex="-1" role="dialog" aria-labelledby="busca" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="formConten">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar {{$chave}} avaria </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>

      <div class="fadeIn first">
        <div id="divMsgEdit"></div>
        <form id="formUpdateAvaria" action="/tipoAvaria/14" method="post" enctype="multipart/form-data">
          @csrf
          @method('put')

          <input type="text" id="idUpdateAVaria" name="id" disabled>
          <input type="text" id="posUpdateAVaria" name="pos" hidden>
          {{-- <input type="text" id="chaveUpdateAvaria" value= name="chaveUpdate"> --}}
          <input type="text" id="descricaoUpdateAVaria">

          <div id="formFooter">
            <div class="d-flex justify-content-center">
              <button onclick="avaria.update('formUpdateAvaria', event, 'divMsgEdit')" type="submit" id="submit" class="fadeIn fourth btn btn-primary">
                salvar
              </button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>