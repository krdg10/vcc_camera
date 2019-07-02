function msgErros(idCampo, msg, seg=3){
	var campo = document.querySelector('#'+idCampo);
	campo.innerHTML = `<span id="error" class="badge badge-danger badge-pill">`+
        msg+
        `<a id="excluir" onClick="excluirElement('success')"><i class="fa fa-times" aria-hidden="true"></i></a>`+
    `</span>`;
	setTimeout(function(){campo.innerHTML='';}, seg * 1000); 
}

function msgSuccess(idCampo, msg, seg=3){
	var campo = document.querySelector('#'+idCampo);
	campo.innerHTML = `<span id="success" class="badge badge-success badge-pill">`+
        msg+
        `<a id="excluir" onClick="excluirElement('success')"><i class="fa fa-times" aria-hidden="true"></i></a>`+
    `</span>`;
	setTimeout(function(){campo.innerHTML='';}, seg * 1000); 
}

function excluirElement(id){
    $('#'+id).remove();
}

function mostrarImgProc(idCampo){
	var campo = document.querySelector('#'+idCampo);
	campo.innerHTML = '<div ><center><p>Aguarde um momento</p><img style="width: 50%" src="/'+varPublic+'img/giphy.gif"></center><div>';
	// setTimeout(function(){
	// 	campo.innerHTML='<img src="/img/ops2.png">';
	// }, 5 * 1000); 
}

function verificarNavegador(){
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
		return true;
    
    else 
        return false;
}

function post(json, url, callback=function(){}, callbackError=function(){}, callbackSend=function(){}){
	var campos = '';
	var chave='';
	for (var i = 0; i < json.length; i++) {
		chave = Object.keys(json[i]);
		campos = campos + `<input name="`+ chave +`" value="` + json[i][chave] + `"> `;
	}

	var form = document.createElement('form');
    form.innerHTML = `<input name="_token" value="`+ csrfToken +`"> ` + campos;
    var objForm = new FormData(form);

    xmlHttpPost(url, objForm, function(){
    	callback()
    },function(){
    	callbackError()
    },function(){
    	callbackSend()
    },);
}