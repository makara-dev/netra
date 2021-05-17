@extends('layout.dashboard')

{{-- Stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{ asset('css/dashboard/customer.css') }}">
@endsection


{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard/customers') }}" class="breadcrumb-link">Customer</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('dashboard_content')
{{-- BEGIN:: Customer Detail --}}
<div class="customer-detail-container">
    <h3 id="detail-title">Customer Detail Info</h3>
    <div class="customer-detail-wrapper">
        {{-- customer image --}}
        <div class="customer-image-wrapper">
            <img src="{{asset('icon/dashboard/unknown-user.png')}}" alt="Customer image">
        </div>
        {{-- customer infomations --}}
        <div class="customer-info-wrapper">
            <div class="row-info">
                <p class="info-text">Customer Name</p>
                <p class="user-data">{{$customer->user->name}}</p>
            </div>
            <div class="row-info">
                <p class="info-text">Email</p>
                <p class="user-data">
                    @if ($customer->user->email != null)
                        {{$customer->user->email}}
                    @else                        
                        <small style="font-size: 14px; color: red;">No Email</small>
                    @endif
                </p>
            </div>
            <div class="row-info">
                <p class="info-text">Contact</p>
                <p class="user-data">
                    @if ($customer->user->contact != null)
                        {{$customer->user->contact}} 
                    @else
                        <small style="font-size: 14px; color: red;">No Contact</small>
                    @endif
                </p>
            </div>
            <div class="row-info">
                <p class="info-text">Points</p>
                <p class="user-data">{{$customer->point}} P</p>
            </div>
            <div class="row-info">
                <p class="info-text">Register Date</p>
                <p class="user-data">{{$customer->user->created_at}}</p>
            </div>
        </div>
    </div>
    <a href="{{url('dashboard/customers')}}" class="btn btn-sm btn-dark rounded align-self-end mr-5 mt-3" style="width: 70px;">
        <small style="font-size: 12px; color: white;">Done</small>
    </a> 
</div>
{{-- END:: Customer Detail --}}
@endsection

@section('dashboard_script')

@endsection
