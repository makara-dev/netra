@extends('layout.app')

<style>
    .font-15 { font-size: 15px; }

    .font-9 { font-size: 9px }

    .mobile-navbar-advertisement,
    .mobile-featured-list-wrapper {
        display: none !important;
    }
    .main-navbar-wrapper {  justify-content: center !important; }
    .navbar-brand-wrapper { margin-left: 0 !important; }

    .col-707070 {
        background-color: #707070 !important;
    }

    .register-header {
        margin: 0 auto 0 auto;
        font-weight: bolder;
    }

    @media only screen and (min-width: 992px) {
        .navbar-menu{ display: flex !important; }

        .card { margin-top: 2.5em; }

        .register-header {
            margin-left: 4.7rem;
            margin-right: auto;
        }
    }
</style>

@section('nav-secondary-container-mobile')
    
@endsection

@section('content')
{{-- BEGIN:: Register Form --}}
<div class="container mt-3 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0">
                {{-- register header --}}
                {{-- <div class="card-header">{{ __('Register') }}</div> --}}
                <h4 class="register-header font-15">BECOME NETRA INSIDER</h4>

                {{-- register body --}}
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        {{-- username --}}
                        <div class="form-group row">
                            {{-- <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label> --}}
                            <div class="col-md-10 mx-auto">
                                <label for="name" class="font-weight-bolder">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control font-weight-bolder @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- email address --}}
                        <div class="form-group row">    
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}
                            <div class="col-md-10 mx-auto">
                                <label for="email" class="font-weight-bolder">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control font-weight-bolder @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- phone number --}}
                        <div class="form-group row">    
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}
                            <div class="col-md-10 mx-auto">
                                <label for="mobile" class="font-weight-bolder">Mobile</label>
                                <input id="mobile" type="tel" class="form-control font-weight-bolder @error('tel') is-invalid @enderror" name="tel" required>

                                @error('tel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- password --}}
                        <div class="form-group row">
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}
                            <div class="col-md-10 mx-auto">
                                <label for="password" class="font-weight-bolder">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control font-weight-bolder @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- confirm password --}}
                        <div class="form-group row">
                            {{-- <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label> --}}
                            <div class="col-md-10 mx-auto">
                                <label for="password-confirm" class="font-weight-bolder">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control font-weight-bolder" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        {{-- privacy policy --}}
                        <div class="form-group row">
                            <div class="col-md-10 mx-auto d-flex">
                                <input type="checkbox" id="privary-checkbox">
                                <small class="font-9 ml-1">By ticking this box you are joining the NETRA INSIDER program and agree to receive newsletter and SMS updates, special offers and a birthday treat. I agree to the <a href="#" class="text-dark" style="text-decoration: underline;">Privacy Policy.</a></small>
                            </div>
                        </div>
                        {{-- register --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-10 offset-md-1">
                                <button type="submit" class="btn btn-primary border-0 col-md-12 p-3 col-707070">
                                    {{-- {{ __('Register') }} --}}
                                    <small class="font-weight-bolder" style="letter-spacing: 2px;">CREATE ACCOUNT</small>
                                </button>
                                <a class="btn btn-link" href="{{route('login')}}">Already Has an Account ?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END:: Register Form --}}
@endsection
