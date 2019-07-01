function mostrarErros(idCampo, msg, seg=3){
	var campo = document.querySelector('#'+idCampo);
	campo.innerHTML = '<p class="alert alert-danger text-center">'+msg+'</p>';
	setTimeout(function(){campo.innerHTML='';}, seg * 1000); 
}

function mostrarSuccess(idCampo, msg, seg=3){
	`<span id="success" class="badge badge-success badge-pill">`+
        msg+
        `<a id="excluir" onClick="excluirElement('success')"><i class="fa fa-times" aria-hidden="true"></i></a>`+
    `</span>`;
	setTimeout(function(){campo.innerHTML='';}, seg * 1000); 
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

// function enviar(valor, ){

// }