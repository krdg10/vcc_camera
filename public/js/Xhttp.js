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


function xmlHttpGet(url, callback) {
    xhttp.onreadystatechange = callback;
    xhttp.open('GET', url);
    xhttp.send();
}

function success(callback){
    if(xhttp.readyState == 4 && xhttp.status ==200){
        callback();
    }
}

function xmlHttpPost(url, parameters, callback) {
    xhttp.onreadystatechange = callback;
    xhttp.open('POST', url);
    xhttp.send(parameters);
}

function xmlHttpDelete(url, callback) {
    xhttp.open("DELETE", url);
    xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken);
    xhttp.onreadystatechange = callback;
    xhttp.send();
}

function xmlHttpPut(url, parameters, callback) {
    var csrfToken = document.querySelector('#csrfToken');;
    xhttp.open("PUT", url);
    xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken.value );
    xhttp.onreadystatechange = callback;
    xhttp.send(parameters);
}

function beforeSend(callback){
	if(xhttp.readyState < 4 ){
		callback();
	}
}

function error(callback){
	xhttp.onerror = callback;
}