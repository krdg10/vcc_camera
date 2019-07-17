<div class="modal fade" id="modalCreateAvaria" tabindex="-1" role="dialog" aria-labelledby="modalCreateAvaria" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="formConten">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar {{$chave}} avaria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="fadeIn first">
                <div id="divMsgCreate"></div>
                <form id="formCreateAvaria">
                    @csrf

                    <input type="text" id="avariaCreate" name="{{$chave}}" placeholder="Novo valor">

                    <div id="formFooter">
                        <div class="d-flex justify-content-center">
                            <button type="submit" id="submit" class="fadeIn fourth btn btn-primary" onclick="avaria.create('tbodyIndex', 'formCreateAvaria', {{$chave}}, 'divMsgCreate', event)" required>Adicionar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>