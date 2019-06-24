@extends('layouts.app')
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
        <img src="logo_vcc.png" id="icon" alt="User Icon" />
        </div>
        @guest
        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input placeholder="Login" id="email" type="text" class="fadeIn second @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input placeholder="Senha" id="password" type="password" class="fadeIn third @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>
           
                <button type="submit" class="fadeIn fourth btn btn-primary">
                    {{ __('Login') }}
                </button>
           
        
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            @if (Route::has('password.request'))
                <a class="underlineHover" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        
        </div>
        @else
            <hr>
            <div class="container">
                <div class="list-group">
                    {{-- INICIO BOTÃO MOTORISTAS --}}
                    <button onclick="accordions('motorista')" class="w3-btn w3-block w3-black w3-left-align">
                        Motoristas
                    </button>
                    <div id="motorista" class="w3-container w3-hide">
                        <a class="list-group-item list-group-item-action" href="{{ url('/motorista') }}">Cadastrar Motoristas</a>
                    </div>
                    <hr>
                    {{-- FIM BOTÃO MOTORISTAS --}}

                    {{-- INICIO BOTÃO CARROS --}}
                    <button onclick="accordions('carros')" class="w3-btn w3-block w3-black w3-left-align">
                        Carros
                    </button>
                    <div id="carros" class="w3-container w3-hide">
                        <a class="list-group-item list-group-item-action" href="{{ url('/carro') }}">Cadastrar Carros</a>
                    </div>
                    <hr>
                    {{-- FIM BOTÃO CARROS --}}

                    {{-- INICIO BOTÃO ENTRADA --}}
                    <button onclick="accordions('entradas')" class="w3-btn w3-block w3-black w3-left-align">
                        Entradas
                    </button>
                    <div id="entradas" class="w3-container w3-hide">
                        <a class="list-group-item list-group-item-action" href="{{ url('/entrada') }}">Cadastrar Entradas</a>
                        <a class="list-group-item list-group-item-action" href="{{ url('/verificacoa') }}">Verificar Entradas</a>
                    </div>
                    {{-- FIM BOTÃO ENTRADA --}}


                </div>
            </div>
            <div id="formFooter">
            </div>
        
        @endguest

    </div>
</div>
 @endsection