class Avaria{
    metodos;
	avarias;
    nomeObj;
	registroAvarias;

	constructor(nomeObj, csrfToken, local='{}', tipo='{}'){
		this.registroAvarias = new Array();
        this.nomeObj = nomeObj;
		this.avarias = {local:JSON.parse(local), tipo:JSON.parse(tipo)};

        this.metodos = new Metodos(csrfToken);
	}

    save(select, chave){
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
        console.log(json);
        metodos.post(json, '/'+ chave +'Avaria', function(r){
            if (r.tipo == 1){
                obj.avarias[chave].push(r.dados);
                obj.setSelect(select.id, chave); 
            }

            metodos.msgSuccess(r.msg)
        });
    }

    create(idTable, idFormCreate, chave, idDivMsg, event){
        var obj = this;
        var formCreate = document.getElementById(idFormCreate);

        this.metodos.xhttp.xmlHttpPost('/'+ chave.name +'Avaria/', new FormData(formCreate), function(r){
            if(r.tipo == 1){
                metodos.msgSuccess(r.msg, idDivMsg);
                document.getElementById('avariaCreate').value = '';

                return true;
            }

            if(r.tipo == 2){
                event.preventDefault();
                obj.metodos.msgError(r.msg, idDivMsg);    
            }

            // if(idDivMsg)
            //     obj.metodos.msgSuccess(r.msg, idDivMsg);
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

    carousel(id, idDivMOdal, imagensString){
        var imagens = JSON.parse(imagensString);
    	var divImg = '';

        this.setarModal(idDivMOdal);

    	var activeClass = 'active';
    	for (var i = 0; i < imagens.length; i++) {
    		divImg = divImg + 
    		`<div class="carousel-item `+ activeClass +`">` +
                `<img class="d-block w-100" id="img`+ imagens[i].id +`" style="height: 300px" src="/storage/`+ imagens[i].path +`" alt="Imagem `+i+`"`+
                `onClick="`+ this.nomeObj +`.modalImage('modalImag', 'img`+ imagens[i].id +`', 'img01', 'caption')">` +
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

    // INJETA O CÓDIGO DO MODAL NA DIV
    setarModal(idDivMOdal){
        document.getElementById(idDivMOdal).innerHTML = `` +
            `<div id="modalImag" class="modal" onclick="`+ this.nomeObj +`.fecharNoVazio(event, this)">`+
                `<span class="close">&times;</span>`+

                `<img class="modal-content" id="img01">`+

                `<div id="caption"></div>`+
            `</div>`;
    }

    fecharNoVazio(e, element) {
        // e é o event. Manda o valor do elemento que foi clicado. 
        //element é o this. manda o valor do elemento que chamou. Acho que precisa de ambos. 
        //e = e || window.event;
        //var target = e.target || e.srcElement;
        //console.log(e.target.classList);//.attr é jquery
        if(e.target.classList=='close'){
            document.getElementById("modalImag").style.display = "none";
            return;
        }
        else if (e.target.classList != element.classList){
            return;
        }
        document.getElementById("modalImag").style.display = "none";
    }

    // EXIBE O MODAL QUANDO A IMAGEM É SELECIONADA
    modalImage(idModal, idImg, idModalImg, idCapion){
        var img = document.getElementById(idImg);

        document.getElementById(idModal).style.display = "block";
        document.getElementById(idModalImg).src = img.src;
        document.getElementById(idCapion).innerHTML = img.alt;
    }

    // FECHA O MODAL
    fecharModal(idModal){
        document.getElementById(idModal).style.display = "none";
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
		            	`<a onClick="`+ this.nomeObj +`.deleteRegistro(`+ z +`, '`+ idExibirRegistroAvarias +`')"><i class="fa fa-times" aria-hidden="true"></i></a>`+
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

    // SETA OS VALORES NO CAMPO DE EDIÇÃO
    edit(chave, pos, event=false){
        var obj = this;
        var idCampo = document.getElementById('idUpdateAVaria');
        var posCampo = document.getElementById('posUpdateAVaria');
        var descricaoCampo = document.getElementById('descricaoUpdateAVaria');

        console.log(obj.avarias);

        posCampo.value = pos;
        idCampo.value = this.avarias[chave][pos].id;
        descricaoCampo.name = chave;
        descricaoCampo.value = this.avarias[chave][pos][chave];
    }

    // ENVIA OS VALORES ATUALIZADOS PARA A CONTROLLER
    update(idFormUpdateAvaria, event, idDivMsg = false){
        var obj = this;
        event.preventDefault();
        var formUpdateAvaria = document.getElementById(idFormUpdateAvaria);

        var id = formUpdateAvaria['id'].value;
        var pos = formUpdateAvaria['pos'].value;
        var chave = document.getElementById('descricaoUpdateAVaria').name;

        this.metodos.xhttp.xmlHttpPost('/'+ chave +'Avaria/' +id, new FormData(formUpdateAvaria), function(r){
            if(r.tipo == 1)
                document.getElementById(chave + id).innerHTML = obj.avarias[chave][pos][chave] = r.dados[chave];

            if(idDivMsg)
                obj.metodos.msgSuccess(r.msg, idDivMsg);
        });
    }
}