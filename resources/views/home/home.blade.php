@extends('layouts.app')

@section('content')
    <div class="wrapper fadeInDown">
        <div id="formContent">

            {{-- LOGO --}}
            <div class="fadeIn first">
                <img src="logo_vcc.png" id="icon" alt="User Icon" />
            </div>
            <hr>

            @guest
                {{-- INCLUDE DO FORMULARIO DE LOGIN --}}
                @include('home.formLogin')

            @else
                {{-- INCLUDE DA TELA DE OPÇÕES --}}
                @include('home.opcoes')

            @endguest

        </div>
    </div>
@endsection