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
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="fadeIn fourth btn btn-primary">
                    {{ __('Login') }}
                </button>
            </div>
        
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
        <div class="container">
            <a class="badge badge-secondary badge-pill" href="{{ url('/motorista') }}">Cadastrar Motoristas</a>
            <a class="badge badge-secondary badge-pill" href="{{ url('/carro') }}">Cadastrar Carros</a>
            <a class="badge badge-secondary badge-pill" href="{{ url('/entrada') }}">Cadastrar Entradas</a>
            </div>
        
        @endguest

    </div>
</div>
 @endsection