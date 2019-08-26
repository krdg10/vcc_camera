<div class="container">
    <div class="list-group">
        {{-- INICIO BOTÃO MOTORISTAS --}}
        <div class="dropdown">
            <button type="button" class="list-group-item list-group-item-action" data-toggle="dropdown">
                Motorista
            </button>
            <div class="dropdown-menu">
                <div class="list-group">
                <a class="list-group-item list-group-item-action" href="{{ url('/motorista/create') }}">Cadastrar Motoristas</a>
                <a class="list-group-item list-group-item-action" href="{{ url('/motorista/listar') }}">Ver Motoristas</a>
                </div>
            </div>
        </div>
        {{-- FIM BOTÃO MOTORISTAS --}}

        {{-- INICIO BOTÃO CARROS --}}
        <div class="dropdown">
            <button type="button" class="list-group-item list-group-item-action" data-toggle="dropdown">
                Veículo
            </button>
            <div class="dropdown-menu">
                <div class="list-group">
                <a class="list-group-item list-group-item-action" href="{{ url('/carro') }}">Cadastrar Veículos</a>
                <a class="list-group-item list-group-item-action" href="{{ url('/carro/listar') }}">Ver Veículos</a>
                </div>
            </div>
        </div>
        {{-- FIM BOTÃO CARROS --}}

        {{-- INICIO BOTÃO ENTRADA --}}
        <div class="dropdown">
            <button type="button" class="list-group-item list-group-item-action" data-toggle="dropdown">
                Entradas
            </button>
            <div class="dropdown-menu">
                <div class="list-group">
                <a class="list-group-item list-group-item-action" href="{{ url('/entrada/create') }}">Cadastrar Entradas</a>
                <a class="list-group-item list-group-item-action" href="{{ url('/entrada') }}">Ver Entradas</a>
                </div>
            </div>

        </div>
        {{-- FIM BOTÃO ENTRADA --}}

        {{-- INICIO BOTÃO ENTRADA --}}
        <div class="dropdown">
            <button type="button" class="list-group-item list-group-item-action" data-toggle="dropdown">
                Avarias Salvas
            </button>
            <div class="dropdown-menu">
                <div class="list-group">
                {{-- <a class="list-group-item list-group-item-action" href="{{ url('/tipoAvaria') }}">Cadastrar Entradas</a> --}}
                <a class="list-group-item list-group-item-action" href="{{ url('/tipoAvaria') }}">Ver Tipos de Avarias</a>
                <a class="list-group-item list-group-item-action" href="{{ url('/localAvaria') }}">Ver Local de Avarias</a>
                </div>
            </div>

        </div>
        {{-- FIM BOTÃO ENTRADA --}}
    </div>
</div>
<div id="formFooter">
</div>