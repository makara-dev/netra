@extends('layout.app')

<style>
    .font-16 { font-size: 16px !important; }
    .font-13 { font-size: 13px !important; }
    .font-11 { font-size: 11px !important; }
    .col-707070 {
        background-color: #707070 !important;
    }

    /* .nav-secondary-container-mobile, .navbar-menu, .footer-subscription{
        display: none !important;
    } */

    .mobile-navbar-advertisement,
    .mobile-featured-list-wrapper {
        display: none !important;
    }
    .main-navbar-wrapper {  justify-content: center !important; }
    .navbar-brand-wrapper { margin-left: 0 !important; }

    .login-header {
        margin: 0 auto 0 auto;
        font-weight: bolder;
        letter-spacing: 1px;
    }

    @media only screen and (min-width: 992px){
        .navbar-menu{ display: flex !important; }

        .login-header {
            margin-left: 7.5rem;
            margin-right: auto;
        }
        .login-wrapper { margin-top: 5rem !important; }
        
        .social-login-wrapper { display: flex; }
        .social-login-wrapper > a { margin: 0 .5em 0 .5em; }
    }
    @media only screen and (min-width: 1199px){
        .login-header { margin-left: 8.8rem; }
    }
</style>

@section('content')
{{-- BEGIN:: Login --}}
<div class="container my-3">
    <div class="row justify-content-center login-wrapper">
        <div class="col-md-8">
            <div class="card border-0">
                <h4 class="login-header font-16">LOGIN</h4>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        {{-- email address --}}
                        <div class="form-group row">
                            <div class="col-12 col-md-10 col-lg-8 mx-auto">
                                <label for="email" class="font-weight-bolder font-13">{{ __('E-MAIL *') }}</label>
                                <input id="email" type="email" class="form-control font-weight-bolder @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- password --}}
                        <div class="form-group row">
                            <div class="col-12 col-md-10 col-lg-8 mx-auto">
                                <label for="email" class="font-weight-bolder font-13">{{ __('PASSWORD *') }}</label>
                                <input id="password" type="password" class="form-control font-weight-bolder @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- remember me --}}
                        <div class="form-group row">
                            <div class="col-12 col-md-10 col-lg-8 mx-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label font-13" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- btn login --}}
                        <div class="form-group row mb-5">
                            <div class="col-12 col-md-10 col-lg-8 mx-auto">
                                {{-- forget password --}}
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link col-md-12 text-right text-dark font-weight-bold font-11" style="text-decoration: underline;" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                {{-- signup --}}
                                <a class="btn btn-link col-md-12 text-right text-dark font-weight-bold font-11" style="text-decoration: underline;" href="{{route('register')}}"> 
                                    Don't have account? Signup
                                </a>
                                {{-- btn login --}}
                                <button type="submit" class="btn btn-primary col-md-12 p-3 mt-2 col-707070 border-0">
                                    <small class="font-weight-bolder" style="letter-spacing: 2px;">LOGIN</small>
                                </button>
                            </div>
                        </div>
                        {{-- social login --}}
                        <div class="form-group">
                             <div class="social-login-wrapper col-12 col-md-10 col-lg-8 p-0 mx-auto">
                                 <a href="{{ url('/login/google') }}" class="col btn btn-light text-dark my-2">Log in with <img class="nav-icon mb-1" src="{{ asset('/icon/google.png') }}" alt="google"></a>
                                 <a href="{{ url('/login/facebook') }}" class="col btn btn-fb text-white my-2" >Log in with <img class="nav-icon mb-1" src="{{ asset('/icon/facebook.png') }}" alt="facebook"></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END:: Login --}}
@endsection
