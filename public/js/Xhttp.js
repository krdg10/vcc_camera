var xhttp;
var request;

try{
    request = new XMLHttpRequest();        
}catch (IEAtual){
    try{
         request = new ActiveXObject("Msxml2.XMLHTTP");       
    }catch(IEAntigo){
        try{
             request = new ActiveXObject("Microsoft.XMLHTTP");          
        }catch(falha){
            request = false;
        }
    }
}
  
if (!request){
    alert("Seu Navegador não suporta Ajax!");
    xhttp = false;
}
else{
 	xhttp = request;
}


function xmlHttpGet(url, callback=function(){}, callbackError=function(){}, callbackSend=function(){}) {
    xhttp.onreadystatechange = function(){
        // OCORREU TUDO BEM
        success(callback());

        // ESTÁ ENVIANDO
        beforeSend(callbackSend());

        // DEU ERRO
        error(callbackError())
    };
    xhttp.open('GET', url);
    xhttp.send();
}

function xmlHttpPost(url, parameters, callback=function(){}, callbackError=function(){}, callbackSend=function(){}) {
    xhttp.onreadystatechange = function(){
        // OCORREU TUDO BEM
        success(callback());

        // ESTÁ ENVIANDO
        beforeSend(callbackSend());

        // DEU ERRO
        error(callbackError());
    };
    xhttp.open('POST', url);
    xhttp.send(parameters);
}

function xmlHttpDelete(url, callback=function(){}, callbackError=function(){}, callbackSend=function(){}) {
    xhttp.open("DELETE", url);
    xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken);
    xhttp.onreadystatechange = function(){
        // OCORREU TUDO BEM
        success(callback());

        // ESTÁ ENVIANDO
        beforeSend(callbackSend());

        // DEU ERRO
        error(callbackError());
    };
    xhttp.send();
}

function xmlHttpPut(url, parameters, callback=function(){}, callbackError=function(){}, callbackSend=function(){}) {
    var csrfToken = document.querySelector('#csrfToken');
    xhttp.open("PUT", url);
    xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken.value );
    xhttp.onreadystatechange = function(){
        // OCORREU TUDO BEM
        success(callback());

        // ESTÁ ENVIANDO
        beforeSend(callbackSend());

        // DEU ERRO
        error(callbackError());
    };
    xhttp.send(parameters);
}

function success(callback){
    if(xhttp.readyState == 4 && xhttp.status ==200)
        callback(JSON.parse(xhttp.responseText));
}

function beforeSend(callback){
	if(xhttp.readyState < 4 )
		callback(JSON.parse(xhttp.responseText));
}

function error(callback){
	xhttp.onerror = callback(JSON.parse(xhttp.responseText));
}