@extends('layout.dashboard')

{{-- Stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{ asset('css/dashboard/cusgroup.css') }}">
@endsection

{{-- page title --}}
@section('page_title','Customer Group Detail')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('cusgroup-list')}}" class="breadcrumb-link">Customer Group</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

{{-- BEGIN:: Customer Group Detail --}}
@section('dashboard_content')
<div class="cusgroup-detail-container mt-5">
    <h3 id="detail-title">Customer Group Detail Info</h3>
    <div class="cusgroup-detail-wrapper">
        {{-- customer group infomations --}}
        <div class="cusgroup-info-wrapper">
            
            <div class="row">
                <div class="col-6">
                    <p class="info-text">Customer Group Name</p>
                </div>
                <div class="col-6">
                    <p class="cus-data">{{$customerGroup->name}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <p class="info-text">Discount</p>
                </div>
                <div class="col-6">
                    <p class="cus-data">{{$customerGroup->discount}} %</p>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <p class="info-text">Customers</p>
                </div>
                <div class="col-6">
                    @foreach ($customerGroup->customers as $key => $item)  
                        <div class="cus_name">
                            {{$key+1}}. {{$item->user->name}}
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
    <a href="{{url('dashboard/customers-group')}}" class="btn btn-sm btn-dark rounded align-self-end mr-5 mt-3" style="width: 70px;">
        <small style="font-size: 12px; color: white;">Done</small>
    </a> 
</div>
@endsection
{{-- END:: Customers group Detail --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/customer-group.js')}}"></script>
    
@endsection
