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
                <input type="text" id="idUpdateAVaria" name="id" disabled>
                <input type="text" id="posUpdateAVaria" name="pos" disabled>
                <input type="text" id="chaveUpdateAVaria" name="chave" disabled>
                <input type="text" id="descricaoUpdateAVaria" name="descricao">
                <div id="formFooter">
                  <div class="d-flex justify-content-center">
                    <button onclick="avaria.updateAVaria(event)" type="submit" id="submit" class="fadeIn fourth btn btn-primary">SALVAR</button>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>