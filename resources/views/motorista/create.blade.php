@extends('layouts.app')
@section('content')
    <script>
        // script valida verifica se há apenas números positivos em cpf, codigo da empresa e codigo vcc. 
        // Alerta de tamanho não precisa script pois minlenght já faz isso
        function valida() {
            var cpf = document.getElementsByName('cpf')[0].value;
            var codigo_empresa = document.getElementsByName('codigo_empresa')[0].value;
            var codigo_transdata = document.getElementsByName('codigo_transdata')[0].value;
            
            var valida = /^\d+$/;

            if (valida.test(cpf) == false){
                metodos.msgError("Verifique o CPF. Apenas números são permitidos!", 'divMsg');
                return false;
            }

            else if (valida.test(codigo_empresa) == false){
                metodos.msgError("Verifique o código da empresa. Apenas números são permitidos!", 'divMsg');
                return false;
            }

            else if (valida.test(codigo_transdata) == false){
                metodos.msgError("Verifique o código transdata. Apenas números são permitidos!", 'divMsg');
                return false;
            }

            return true;
        }
    </script>

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h3>Cadastrar Motorista</h3> 
            
            @include('layouts.messages')
            <hr>

            <form method="POST" action="{{ route('motorista.store') }}" enctype="multipart/form-data" onsubmit="return valida();">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="nome">Nome <a class="color-red">*</a></label>
                    <input type="text" placeholder="Nome" name="nome" class="form-control" max="250" value="{{\Session::get('resposta')["nome"]}}" required>
                    <!-- <small>blabla</small>ver como fica esse small. Essa alteração foi de formgroup, labele e esse value.  display tem que ser igual da label.-->
                </div>
                <div class="form-group">
                    <label for="cpf">CPF <a class="color-red">*</a></label>
                    <input type="text" placeholder="CPF" name="cpf" class="form-control" maxlength="11" minlength="11" value="{{\Session::get('resposta')["cpf"]}}" required>
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento <a class="color-red">*</a></label>
                    <input type="date" placeholder="Data de Nascimento" name="data_nascimento" class="form-control" value="{{\Session::get('resposta')["data_nascimento"]}}" required>
                </div>
                <div class="form-group">
                    <label for="codigo_empresa">Código VCC <a class="color-red">*</a></label>
                    <input type="text" placeholder="Código VCC" name="codigo_empresa" class="form-control" maxlength="4" minlength="4" value="{{\Session::get('resposta')["codigo_empresa"]}}" required>
                </div>
                <div class="form-group">
                    <label for="codigo_transdata">Código Transdata <a class="color-red">*</a></label>
                    <input type="text" placeholder="Código Transdata" name="codigo_transdata" class="form-control" maxlength="5" minlength="5" value="{{\Session::get('resposta')["codigo_transdata"]}}" required>
                </div>
                <div id="formFooter">
                    <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Salvar </button>
                </div>
            </form>
        </div>
    </div>
@endsection
