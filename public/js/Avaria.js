class Avaria{
	avarias;
	registroAvarias;

	constructor(local, tipo){
		this.registroAvarias = new Array();
		this.avarias = {local:JSON.parse(local), tipo:JSON.parse(tipo)};
	}

    storeAVaria(select, chave, pos, url){
    	var obj = this;
        // VERIFICA SE O VALOR NOVO FOI SELECIONADO
        if (select.value != 'novo') return false;

        var valor = prompt ("Inserir novo "+ chave +" avaria");

        // VERIFICA SE O CAMPO ESTA VAZIO
        if(valor == '' || valor == null){
            alert("Nenhum valor inserido.");
            return false;
        }

        var json = JSON.parse('[{"'+ chave +'":"'+ valor +'"}]');
        metodos.post(json, url, function(r){
            if (r.tipo == 1){
                obj.avarias[chave].push(r.dados);
                obj.setSelect(select.id, chave); 
            }

            metodos.msgSuccess(r.msg)
        });
    }

    // FUNÇÃO PARA CRIAR AS OPTION SETAR NA SELECT
    setSelect(id, chave, value_padrao=false, novo=true){
    	// CRIA AS OPTION
        var option = '<option value="false">Selecione o '+ chave +' da avaria</option>';
        for (var i = 0; i < this.avarias[chave].length; i++) 
            option = option + `<option value="`+ this.avarias[chave][i].id +`">`+this.avarias[chave][i].id + `-` + this.avarias[chave][i][chave] +`</option>`

        // CASO NÃO QUEIRA CAMPO PARA REGISTRAR NOVO TIPO OU LOCAL
        if (novo) 
            option = option + `<option value="novo">Novo `+ chave +` de avaria</option>`;

        document.getElementById(id).innerHTML = option;
        if(value_padrao) document.getElementById(id).value = value_padrao;
    }

    carousel(id, imagens){
    	var divImg = '';
    	var activeClass = 'active';
    	for (var i = 0; i < imagens.length; i++) {
    		divImg = divImg + 
    		`<div class="carousel-item `+ activeClass +`">` +
                `<img class="d-block w-100" style="height: 300px" src="/storage/`+ imagens[i].path +`" alt="Primeiro Slide">` +
            `</div> `;
            activeClass = '';
    	}

    	document.getElementById(id).innerHTML = ``+
    	`<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">` +
            `<div class="carousel-inner">` +
                divImg+
            `</div>` +
            `<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">` +
                `<span class="carousel-control-prev-icon" aria-hidden="true"></span>` +
                `<span class="sr-only">Anterior</span>` +
            `</a>` +
            `<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">` +
                `<span class="carousel-control-next-icon" aria-hidden="true"></span>` +
                `<span class="sr-only">Próximo</span>` +
            `</a>` +
        `</div>`;
    }

    setRegistrarVerificacao(idSelectLocal, idSelectTipo, idObs, idExibirRegistroAvarias){
    	var selectLocal = document.getElementById(idSelectLocal);
    	var selectTipo = document.getElementById(idSelectTipo);
    	var obs = document.getElementById(idObs);
    	var obj = this;

    	// VERIFICA SE O TIPO E LOCAL DE AVARIA FORAM PREENCHIDOS
        if (selectLocal.value == 'false' || selectTipo.value == 'false')
            return alert('Selecione local e tipo.');

        this.registroAvarias.push({'local': selectLocal.value, 'tipo': selectTipo.value, 'obs': obs.value });
        this.exibirRegistroAvarias(idExibirRegistroAvarias);
    }

    deleteRegistro(pos, idExibirRegistroAvarias){
        this.registroAvarias.splice(pos, 1);
    	this.exibirRegistroAvarias(idExibirRegistroAvarias);
    }

    exibirRegistroAvarias(idExibirRegistroAvarias){
        var text = '', localString = '', tipoString = '';
        for(var z in this.registroAvarias){
        	localString = this.procura(z, 'local');
        	tipoString = this.procura(z, 'tipo');

            text += `<span id="registroAvaria`+ z +`" class="badge badge-primary badge-pill">`+
		            	localString +` - `+ tipoString +` - `+ this.registroAvarias[z].obs +
		            	`<input type="text" value="`+ this.registroAvarias[z].local +`" name="local[]" class="d-none">`+
		            	`<input type="text" value="`+ this.registroAvarias[z].tipo +`" name="tipo[]" class="d-none">`+
		            	`<input type="text" value="`+ this.registroAvarias[z].obs +`" name="obs[]" class="d-none">  `+
		            	`<a onClick="avaria.deleteRegistro(`+ z +`, '`+ idExibirRegistroAvarias +`')"><i class="fa fa-times" aria-hidden="true"></i></a>`+
	            	`</span> `;
        }
        document.getElementById(idExibirRegistroAvarias).innerHTML = text;
    }

    procura(pos, chave){
    	var r = this.registroAvarias[pos][chave];
		var campo = 'Nada', a;
        for (var w = 0; w < this.avarias[chave].length; w++){
        	a = this.avarias[chave][w];

            if(a.id == r)
                return campo = a[chave];
        }
	}

    habilitarTipo(selectLocal, idSelectTipo){
        var selectTipo = document.getElementById(idSelectTipo);

        if(selectLocal.value == 'false' || selectLocal.value == 'novo'){
            selectTipo.disabled = true;
            selectTipo.value = false;
        }

        else{
            selectTipo.disabled = false;
        }    
    }
}