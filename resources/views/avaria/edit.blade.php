<div class="modal fade" id="editAvaria" tabindex="-1" role="dialog" aria-labelledby="busca" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="formConten">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar Motorista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="fadeIn first">
              <form id="formUpdateAvaria">
                <input id="idUpdateAVaria" name="id" disabled>
                <input id="posUpdateAVaria" name="pos" disabled>
                <input id="chaveUpdateAVaria" name="chave" disabled>
                <input id="descricaoUpdateAVaria" name="descricao">

                <button onclick="avaria.updateAVaria(event)">SALVAR</button>
              </form>
            </div>
        </div>
    </div>
</divr