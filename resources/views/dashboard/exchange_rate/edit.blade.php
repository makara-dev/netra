@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/exchange_rate.css')}}">
    
@endsection

{{-- page title --}}
@section('page_title','Exchange Rates Edit')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('exrate-list')}}" class="breadcrumb-link">Exchange Rates</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

{{-- BEGIN:: Exchange Rate Edit --}}
@section('dashboard_content')

<div class="edit-exrate-content-wrapper mt-5" style="width: 90%;">
    <form id="exrate-edition-form" action="{{ route('exrate-update', ['id' => $exchangeRate->id]) }}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf
        {{-- general information --}}
        <div class="general-info-wrapper">
            <div class="form-row">
                {{-- currency code --}}
                <div class="form-group col-md-4">
                    <label for="currency-code">Currency Code</label>
                    <input type="text" value="{{ $exchangeRate->currency_code }}" class="form-control" name="currency-code" id="currency-code" required>
                </div>

                {{-- currency name --}}
                <div class="form-group col-md-4">
                    <label for="currency-name">Currency Name</label>
                    <input type="text" value="{{$exchangeRate->currency_name}}" class="form-control" name="currency-name" id="currency-name" required>
                </div>
            </div>

            <div class="form-row">
                {{-- exchange rate --}}
                <div class="form-group col-md-4">
                    <label for="exrate">Exchange Rate</label>
                    <input type="number" value="{{$exchangeRate->exchange_rate}}" min="0" step="any" class="form-control" name="exrate" id="exrate" required>
                </div>

                {{-- symbol --}}
                <div class="form-group col-md-4">
                    <label for="symbol">Symbol</label>
                    <input type="text" value="{{$exchangeRate->symbol}}" class="form-control" name="symbol" id="symbol" required>
                </div>
            </div>

        </div>

        {{-- add & reset button --}}
        <div class="exrate-btn-wrapper form-row">
            <input type="submit" id="exrate-submit" class="btn btn-sm btn-outline-dark mr-2" value="Update exchange rate">
            <a href="/dashboard/exchange-rate" class="btn btn-sm btn-outline-danger mr-2">Back</a>
        </div>
    </form>
</div>

@endsection
{{-- END:: Exchange Rate Edit --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/exchage_rate.js')}}"></script>
@endsection