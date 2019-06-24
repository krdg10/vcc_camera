@extends('layouts.app')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
        <img src="logo_vcc.png" id="icon" alt="User Icon" />
        </div>
        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input placeholder="Nome" id="name" type="text" class="fadeIn second @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input id="email" type="text" class="fadeIn third @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
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
            <input id="password-confirm" placeholder="Confirmar Senha" type="password" class="fadeIn third" name="password_confirmation" required autocomplete="new-password">
            
           
            <div id="formFooter">
                <button type="submit" class="fadeIn fourth btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
           
        
        </form>
        
    </div>
</div>
@endsection
