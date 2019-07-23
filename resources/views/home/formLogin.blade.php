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
</div>