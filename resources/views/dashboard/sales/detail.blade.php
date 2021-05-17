@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/sale.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.datetimepicker.min.css')}}">
@endsection

{{-- page title --}}
@section('page_title','Sale Detail')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="{{route('sale-list')}}" class="breadcrumb-link">Sale</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

{{-- BEGIN:: Sale Detail --}}
@section('dashboard_content')
<div class="sale-content-wrapper mt-5">
    <p>{{$sale->id}}</p>
    <p>{{$sale->datetime}}</p>
    <p>{{$sale->reference_num}}</p>
    <p>{{$sale->sale_status}}</p>
    <p>{{$sale->payment_status}}</p>
    <p>{{$sale->total}}</p>
    <p>{{$sale->paid}}</p>
    <p>{{$sale->discount}}</p>
</div>
@endsection
{{-- END:: Sale --}}

{{-- custom script --}}
@section('dashboard_script')

<script>
    // show confirm delete message
    $('.sale-delete-btn').on('click', function() {
        return confirm('Do you really want to delete this sale record?');
    });
</script>
@endsection