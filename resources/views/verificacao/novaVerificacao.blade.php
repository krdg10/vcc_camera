<div class="container">
    <h4 style="margin-top: 0.5rem">Inserir Avaria (Caso Haja)</h4>
    {{-- SELECT LOCAL AVARIA --}}
    <div class="form-group">
        <label for="localAvariaNovo">Local da Avaria</label>
        <select class="MineSelect" name="" id="localAvariaNovo" onchange="avaria.save(this, 'local)"></select>
    </div>

    {{-- SELECT TIPO DE AVARIA --}}
    <div class="form-group">
        <label for="tipoAvariaNovo">Tipo da Avaria</label>
        <select class="MineSelect" name="tipoAvaria" id="tipoAvariaNovo" onchange="avaria.save(this, 'tipo')"></select>
    </div>

    <div id="addObs" class="row" >
        {{-- DIV CAMPO OBSERVAÇÃO --}}
        <div class="col-sm-9 col-md-6 col-lg-8" style="flex: 0 0 76.666667%; max-width: 86.666667%;">
            <div class="form-group">
                <label for="observacao">Obervação</label>
                <textarea placeholder="Observação" name="observacao" id="observacao"></textarea>
            </div>
        </div>
        
        {{-- BUTTON PARA ADICIONAR NOVA VERIFICAÇÃO --}}
        <div id="btnObs"><button type="button" class="btn btn-outline-primary" onclick="avaria.setRegistrarVerificacao('localAvariaNovo', 'tipoAvariaNovo', 'observacao', 'divRegistroAvarias')">+</button></div>
    </div>
</div>