<div class="modal fade" id="modalCreateAvaria" tabindex="-1" role="dialog" aria-labelledby="modalCreateAvaria" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="formConten">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Tipo Avaria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="fadeIn first">
                <form method="POST" action="{{ route('tipoAvaria.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="tipoAvaria" name="tipoAvaria" placeholder="Tipo">
                    <div id="formFooter">
                        <div class="d-flex justify-content-center">
                            <button type="submit" id="submit" class="fadeIn fourth btn btn-primary" required>Adicionar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>