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
        @section('title','Dashboard')
    </title>

    {{-- font --}}
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/dashboard.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&display=swap" rel="stylesheet">
    @yield('dashboard_stylesheet')

</head>

<body>
    
    <div class="dashboard-main-wrapper">
        @include('dashboard.partials.navbar')
        @include('dashboard.partials.sidebar')
        {{-- wrapper --}}
        <section class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header m-0">
                                <div class="page-breadcrumb">
                                    <h2 class="text-dark">@yield('page_title')</h2>
                                    <nav aria-label="breadcrumb py-4">
                                        <ol class="breadcrumb">
                                            {{-- Bread Crumbs // Path --}}
                                            @yield('breadcrumb')
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('partials.flash-message')
                    {{-- Dashboard Content --}}
                    @yield('dashboard_content')

                </div>
            </div>
        </section>
    </div>
</body>


<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/dashboard.min.js')}}"></script>

{{-- custom script --}}
<script src="{{asset('js/dashboard/search.js')}}"></script>
@yield('dashboard_script')