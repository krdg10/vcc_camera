class Metodos {
	xhttp;
	nomeObj;
	csrfToken;

	constructor(nomeObj, csrfToken){
		this.csrfToken = csrfToken;
		this.nomeObj = nomeObj;
		this.xhttp = new Xhttp(this.csrfToken);
	}

	msgSuccess(msg, idCampo='divMsg', seg=false){
		var campo = document.querySelector('#'+idCampo);
		var rand = Math.floor(Math.random() * (10000 - 1));
		campo.innerHTML = `<span id="success`+ rand +`" class="badge badge-success badge-pill">`+
	        msg+
	        `<a id="excluir" onClick="`+ this.nomeObj +`.excluirElement('success`+ rand +`')"><i class="fa fa-times" aria-hidden="true"></i></a>`+
	    `</span>`;
		if(seg)setTimeout(function(){campo.innerHTML='';}, seg * 1000); 
	}

	msgError(msg, idCampo='divMsg', seg=false){
		var campo = document.querySelector('#'+idCampo);
		var rand = Math.floor(Math.random() * (10000 - 1));
		campo.innerHTML = `<span id="error`+ rand +`" class="badge badge-danger badge-pill">`+
	        msg+
	        `<a id="excluir" onClick="`+ this.nomeObj +`.excluirElement('error`+ rand +`')"><i class="fa fa-times" aria-hidden="true"></i></a>`+
	    `</span>`;
		if(seg)setTimeout(function(){campo.innerHTML='';}, seg * 1000); 
	}

	excluirElement(id){
	    $('#'+id).remove();;
	}

	mostrarImgProc(idCampo){
		var campo = document.querySelector('#'+idCampo);
		campo.innerHTML = '<div ><center><p>Aguarde um momento</p><img style="width: 50%" src="/'+varPublic+'img/giphy.gif"></center><div>';
		// setTimeout(function(){
		// 	campo.innerHTML='<img src="/img/ops2.png">';
		// }, 5 * 1000); 
	}

	verificarNavegador(){
	    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
			return true;
	    
	    else 
	        return false;
	}

	post(json, url, callback=function(){}, callbackError=function(){}, callbackSend=function(){}){
		var campos = `<input name="_token" value="`+ this.csrfToken +`"> `;
		var colunas = '';
		for (var i = 0; i < json.length; i++) {
			colunas = Object.keys(json[i]);

			for (var z = 0; z < colunas.length; z++) 
				campos += `<input name="`+ colunas[z] +`" value="` + json[i][colunas[z]] + `"> `;
		}

		var form = document.createElement('form');
	    form.innerHTML = campos;

	    this.xhttp.xmlHttpPost(url, new FormData(form), callback, callbackError, callbackSend);
	}
}