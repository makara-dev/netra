<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- title --}}
    <link rel="shortcut icon" href="{{asset('icon/netra-icon.svg')}}" />
    <title>
        @section('title')
        {{ config('app.name', 'Laravel') }}
        @show
    </title>

    {{-- font --}}
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto&display=swap" rel="stylesheet">

    @section('stylesheet')
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/navbar-menu.css')}}">
        <link rel="stylesheet" href="{{ asset('css/header.css') }}">
        <link rel="stylesheet" href="{{asset('css/footer.css')}}">
    @show

</head>

<body>
    {{-- header --}}
    <header>
        @section('header')
            @include('partials.header-nav')
            @include('partials.navbar')
            @include('partials.flash-message')
        @show
    </header>

    {{-- main content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- footer --}}
    <footer id="main-footer">
        @section('footer')
            @include('partials.footer')
        @show
    </footer>
</body>
  {{-- javascript --}}
  <script src="{{asset('js/app.js')}}"></script>
  
  {{-- navigation bar animation --}}
  <script src="{{asset('js/custom-navbar-animation.js')}}"></script>

  @section('main_script')
    {{--  --}}
  @show

  @yield('script')

</html>