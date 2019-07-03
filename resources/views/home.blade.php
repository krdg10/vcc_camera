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
                   {{-- <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>--}}
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
                    <div class="dropdown">
                        <button type="button" class="list-group-item list-group-item-action" data-toggle="dropdown">
                            Motorista
                        </button>
                        <div class="dropdown-menu">
                            <div class="list-group">
                            <a class="list-group-item list-group-item-action" href="{{ url('/motorista') }}">Cadastrar Motoristas</a>
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


                </div>
            </div>
            <div id="formFooter">
            </div>
        
        @endguest

    </div>
</div>
 @endsection