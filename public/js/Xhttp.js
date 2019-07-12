class Xhttp {
    xhttp = '';
    request = '';
    csrfToken;

    constructor(csrfToken){
        this.csrfToken = csrfToken

        try{
            this.request = new XMLHttpRequest();        
        }catch (IEAtual){
            try{
                this.request = new ActiveXObject("Msxml2.XMLHTTP");       
            }catch(IEAntigo){
                try{
                    this.request = new ActiveXObject("Microsoft.XMLHTTP");          
                }catch(falha){
                    this.request = false;
                }
            }
        }
          
        if (!this.request){
            alert("Seu Navegador não suporta Ajax!");
            this.xhttp = false;
        }
        else{
         	this.xhttp = this.request;
        }
    }

    xmlHttpGet(url, callback=function(){}, callbackError=function(){}, callbackSend=function(){}) {
        var obj = this;
        this.xhttp.onreadystatechange = function(){
            // OCORREU TUDO BEM
            obj.success(callback);

            // ESTÁ ENVIANDO
            obj.beforeSend(callbackSend);

            // DEU ERRO
            obj.error(callbackError)
        };
        this.xhttp.open('GET', url);
        this.xhttp.send();
    }

    xmlHttpPost(url, parameters, callback=function(){}, callbackError=function(){}, callbackSend=function(){}) {
        var obj = this;
        this.xhttp.onreadystatechange = function(){
            // OCORREU TUDO BEM
            obj.success(callback);

            // ESTÁ ENVIANDO
            obj.beforeSend(callbackSend);

            // DEU ERRO
            obj.error(callbackError);
        };
        this.xhttp.open('POST', url);
        this.xhttp.send(parameters);
    }

    xmlHttpDelete(url, callback=function(){}, callbackError=function(){}, callbackSend=function(){}) {
        var obj = this;
        this.xhttp.open("DELETE", url);
        this.xhttp.setRequestHeader("X-CSRF-TOKEN", this.csrfToken);
        this.xhttp.onreadystatechange = function(){
            // OCORREU TUDO BEM
            obj.success(callback);

            // ESTÁ ENVIANDO
            obj.beforeSend(callbackSend);

            // DEU ERRO
            obj.error(callbackError);
        };
        this.xhttp.send();
    }

    xmlHttpPut(url, parameters, callback=function(){}, callbackError=function(){}, callbackSend=function(){}) {
        var obj = this;
        this.xhttp.open("PUT", url);
        this.xhttp.setRequestHeader("X-CSRF-TOKEN", obj.csrfToken );
        this.xhttp.onreadystatechange = function(){
            // OCORREU TUDO BEM
            obj.success(callback);

            // ESTÁ ENVIANDO
            obj.beforeSend(callbackSend);

            // DEU ERRO
            obj.error(callbackError);
        };
        this.xhttp.send(parameters);
    }

    success(callback){
        if(this.xhttp.readyState == 4 && this.xhttp.status ==200)
            callback(JSON.parse(this.xhttp.responseText));
        
    }

    beforeSend(callback){
        var obj = this;
    	if(this.xhttp.readyState < 4 )
    		callback(obj.xhttp.responseText);
    }

    error(callback){
    	this.xhttp.onerror = callback(JSON.parse(this.xhttp.responseText));
    }
}