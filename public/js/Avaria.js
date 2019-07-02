class Avaria{
    storeLocalAVaria(selectAvaria){
        var obj = this;
        // VERIFICA SE O VALOR NOVO FOI SELECIONADO
        if (selectAvaria.value != 'novo') return false;

        var localAVariaTxt = prompt ("Inserir novo local avaria");

        // VERIFICA SE O CAMPO ESTA VAZIO
        if(localAVariaTxt == '' || localAVariaTxt == null){
            metodos.msgSuccess("Nenhum valor inserido.");
            return false;
        }

        metodos.post([{'local':localAVariaTxt}], '/localAvaria', function(r){
            if (r.tipo == 1){
                obj.localAvarias.push(r.dados);
                setSelect(selectAvaria.id, obj.localAvarias, 'local', 'Selecione o local da avaria'); 
            }

            metodos.msgSuccess(r.msg)
        });
    }   

    storeAVaria(select, msg, pos, url){
    	var obj = this;
        // VERIFICA SE O VALOR NOVO FOI SELECIONADO
        if (select.value != 'novo') return false;

        var valor = prompt ("Inserir novo "+ msg +" avaria");

        // VERIFICA SE O CAMPO ESTA VAZIO
        if(valor == '' || valor == null){
            alert("Nenhum valor inserido.");
            return false;
        }

        var json = JSON.parse('[{"'+ msg +'":"'+ valor +'"}]');
        metodos.post(json, url, function(r){
            if (r.tipo == 1){
                avarias[pos].push(r.dados);
                console.log(r.dados);
                obj.setSelect(select.id, avarias[pos], msg, 'Selecione o '+ msg +' da avaria'); 
            }

            metodos.msgSuccess(r.msg)
        });
    }

    // FUNÇÃO PARA CRIAR AS OPTION SETAR NA SELECT
    setSelect(id, array, chave, msg, novo=true){
        var option = '<option value="false">'+ msg +'</option>';
        for (var i = 0; i < array.length; i++) 
            option = option + `<option value="`+ array[i].id +`">`+ array[i][chave] +`</option>`

        // CASO NÃO QUEIRA CAMPO PARA REGISTRAR NOVO TIPO OU LOCAL
        if (novo) 
            option = option + `<option value="novo">Novo tipo de avaria</option>`;

        document.getElementById(id).innerHTML = option;
    }
}