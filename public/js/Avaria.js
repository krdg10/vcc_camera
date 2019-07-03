class Avaria{
	avarias;
	registroAvarias;

	constructor(localAvarias, tipoAvarias){
		this.registroAvarias = new Array();
		this.avarias = {localAvarias:JSON.parse(localAvarias), tipoAvarias:JSON.parse(tipoAvarias)};
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
                obj.avarias[chave  + 'Avarias'].push(r.dados);
                obj.setSelect(select.id, chave); 
            }

            metodos.msgSuccess(r.msg)
        });
    }

    // FUNÇÃO PARA CRIAR AS OPTION SETAR NA SELECT
    setSelect(id, chave, novo=true){
    	// CRIA AS OPTION
        var option = '<option value="false">Selecione o '+ chave +' da avaria</option>';
        for (var i = 0; i < this.avarias[chave + 'Avarias'].length; i++) 
            option = option + `<option value="`+ this.avarias[chave + 'Avarias'][i].id +`">`+this.avarias[chave + 'Avarias'][i].id + `-` + this.avarias[chave + 'Avarias'][i][chave] +`</option>`

        // CASO NÃO QUEIRA CAMPO PARA REGISTRAR NOVO TIPO OU LOCAL
        if (novo) 
            option = option + `<option value="novo">Novo `+ chave +` de avaria</option>`;

        document.getElementById(id).innerHTML = option;
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

    registrarVerificacao(idSelectLocal, idSelectTipo, idObs, idExibirRegistroAvarias){
    	var selectLocal = document.getElementById(idSelectLocal);
    	var selectTipo = document.getElementById(idSelectTipo);
    	var obs = document.getElementById(idObs);
    	var obj = this;

    	// VERIFICA SE O TIPO E LOCAL DE AVARIA FORAM PREENCHIDOS
        if (selectLocal == 'false' || selectTipo == 'false')
            return alert('Selecione local e tipo.');

        // PROCURA PELO VALOR DO LOCAL DA AVARIA
        var localString = 'Nada', l;
        for (var x = 0; x < this.avarias['localAvarias'].length; x++){
        	l = this.avarias['localAvarias'][x];
            if(l.id == selectLocal.value){
                localString = l.local;
                break;
            }
        }

        // PROCURA PELO VALOR DO TIPO DE AVARIA
        var tipoString = 'Nada', t;
        for (var w = 0; w < this.avarias['tipoAvarias'].length; w++){
        	t = this.avarias['tipoAvarias'][w];
            if(t.id == selectTipo.value){
                tipoString = t.tipo;
                break;
            }
        }

        this.registroAvarias.push({'local': selectLocal.value, 'tipo': selectTipo.value, 'obs': obs.value });
        this.setRegistroVerificacao(idExibirRegistroAvarias);
    }

    deleteRegistro(pos, idExibirRegistroAvarias){
        this.registroAvarias.splice(pos, 1);
    	this.setRegistroVerificacao(idExibirRegistroAvarias);
    }

    setRegistroVerificacao(idExibirRegistroAvarias){
        var text = '', localString = '', tipoString = '';
        for(var z in this.registroAvarias){
        	localString = this.procura(this.registroAvarias[z].id, 'local');
        	tipoString = this.procura(this.registroAvarias[z].id, 'tipo');

            text += '<span id="'+ this.registroAvarias[z].id +'" class="badge badge-primary badge-pill">'+ 
		            	localString +' - '+ tipoString +' - '+ this.registroAvarias[z].obs +
		            	'<input type="text" value="'+ this.registroAvarias[z].local +'" name="local[]" class="d-none">'+
		            	'<input type="text" value="'+ this.registroAvarias[z].tipo +'" name="tipo[]" class="d-none">'+
		            	'<input type="text" value="'+ this.registroAvarias[z].obs +'" name="obs[]" class="d-none">  '+
		            	'<a onClick="avaria.deleteRegistro('+ z +', '+ idExibirRegistroAvarias +')"><i class="fa fa-times" aria-hidden="true"></i></a>'+
	            	'</span> ';
        }
        document.getElementById(idExibirRegistroAvarias).innerHTML = text;
    }

    procura(id, chave){
    	console.log('id', id);
    	console.log('chave', chave);
		var campo = 'Nada', a;
        for (var w = 0; w < this.avarias[chave + 'Avarias'].length; w++){
        	a = this.avarias[chave + 'Avarias'][w];

            if(a.id == id){
            	// console.log(id);
            	// console.log(a.id);
                return campo = a[chave];
            }
        }
	}
}