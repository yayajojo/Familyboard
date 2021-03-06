@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="mx-auto w-1/3">
        
            <div class="card">
                <div class="text-black text-lg">{{ __('Login') }}</div>

                <div class="flex-col">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div >
                            <label for="email" >{{ __('E-Mail Address') }}</label>

                            <div>
                                <input id="email" type="email" class="w-full @error('email') text-red-700 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex-col">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="w-full @error('password') text-red-700 @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex-col">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="my-3">
                            <div class="flex-col">
                                <button type="submit" class="button-add">
                                    {{ __('Login') }}
                                </button>
                                <div>
                                @if (Route::has('password.request'))
                                    <a class="text-red-700" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
</div>
@endsection
