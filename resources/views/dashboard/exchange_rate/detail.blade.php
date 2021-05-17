@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/exchange_rate.css')}}">
    
@endsection

{{-- page title --}}
@section('page_title','Exchange Rates Detail')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('exrate-list')}}" class="breadcrumb-link">Exchange Rates</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

{{-- BEGIN:: Exchange Rate Detail --}}
@section('dashboard_content')

<div class="exrate-detail-container mt-5">
    <h3 id="detail-title">Exchange Rate Detail Info</h3>
    <div class="exrate-detail-wrapper">
        {{-- exchange rate infomations --}}
        <div class="exrate-info-wrapper">
            
            {{-- currency code --}}
            <div class="row">
                <div class="col-6">
                    <p class="info-text">Currency Code</p>
                </div>
                <div class="col-6">
                    <p class="cus-data">{{$exchangeRate->currency_code}}</p>
                </div>
            </div>

            {{-- currency name --}}
            <div class="row">
                <div class="col-6">
                    <p class="info-text">Currency Name</p>
                </div>
                <div class="col-6">
                    <p class="cus-data">{{$exchangeRate->currency_name}}</p>
                </div>
            </div>

            {{-- exchange rate --}}
            <div class="row">
                <div class="col-6">
                    <p class="info-text">Exchange Rate</p>
                </div>
                <div class="col-6">{{number_format($exchangeRate->exchange_rate, 2)}}</div>
            </div>

            {{-- symbol --}}
            <div class="row">
                <div class="col-6">
                    <p class="info-text">Symbol</p>
                </div>
                <div class="col-6">{{$exchangeRate->symbol}}</div>
            </div>
            
        </div>
    </div>
    <a href="{{url('dashboard/exchange-rate')}}" class="btn btn-sm btn-dark rounded align-self-end mr-5 mt-3" style="width: 70px;">
        <small style="font-size: 12px; color: white;">Done</small>
    </a> 
</div>

@endsection
{{-- END:: Exchange Rate Detail --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/exchage_rate.js')}}"></script>
@endsection