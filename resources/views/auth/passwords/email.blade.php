@extends('layouts.app')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">
            <img src="{{ url('logo_vcc.png') }}" id="icon" alt="User Icon" />
        </div>
        <div class="card-header">{{ __('Reset Password') }}</div>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input id="email" type="email" class="fadeIn second @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div id="formFooter">
                <button type="submit" class="btn btn-primary">
                    {{ __('Envie o link para alterar a senha.') }}
                </button>
            </div>
        </form>         
    </div>
</div>
@endsection
