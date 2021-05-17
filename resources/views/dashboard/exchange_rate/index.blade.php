@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/exchange_rate.css')}}">
    
@endsection

{{-- page title --}}
@section('page_title','Exchange Rates')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Exchange Rates</li>
@endsection

{{-- BEGIN:: Exchange Rate --}}
@section('dashboard_content')

<div class="customer-content-wrapper">
    <div class="customer-add-btn mb-2" style="text-align: end;">
        <a class="btn btn-sm btn-outline-dark" href="{{ route('exrate-add') }}">Create New Exchange Rate</a>
    </div>

    <table class="table shadow-lg bg-white mt-3">
        {{-- table head --}}
        <thead class="thead-dark thead-btn">
            <tr>
                <th>#Id</th>
                <th>Currency Code</th>
                <th>Currency Name</th>
                <th>Exchange Rate</th>
                <th>Symbol</th>
                <th>Action</th>
            </tr>
        </thead>
        {{-- table body --}}
        <tbody id="myTable">
            @foreach ($exchangeRates as $key => $exchangeRate)
            <tr>
                <td>#{{$key+1}}</td>
                <td>{{$exchangeRate->currency_code}}</td>
                <td>{{$exchangeRate->currency_name}}</td>
                <td>{{number_format($exchangeRate->exchange_rate, 2)}}</td>
                <td>{{$exchangeRate->symbol}}</td>
                <td>
                    {{-- action dropdown menu --}}
                    <img type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="{{asset('icon/dashboard/action.png')}}" alt="action icon">
                    {{-- dropdown items --}}
                    <div class="dropdown-menu dropdown-menu-left">
                        {{-- see detail --}}
                        <div class="action-see-detail-wrapper">
                            <a class="dropdown-item" href="{{ route('exrate-detail', ['id' => $exchangeRate->id]) }}">See Detail</a>
                        </div>
                        {{-- edit --}}
                        <div class="action-edit-wrapper">
                            <a class="dropdown-item" href="{{url("dashboard/exchange-rate/$exchangeRate->id/edit")}}">Edit</a>
                        </div>
                        {{-- delete --}}
                        <div class="action-delete-wrapper">
                            <form action="{{ route('exrate-delete', ['id' => $exchangeRate->id]) }}" method="POST">
                                @method('delete')
                                @csrf
                                <button class="exrate-delete-btn dropdown-item">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
{{-- END:: Exchage Rate --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/exchage_rate.js')}}"></script>
@endsection