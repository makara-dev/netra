@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/quotation.css')}}">
@endsection

{{-- page title --}}
@section('page_title','Quotation Detail')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="{{route('quotation-list')}}" class="breadcrumb-link">Quotation</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

{{-- BEGIN:: detail quotation --}}
@section('dashboard_content')
    <div class="quotation-detail mt-5">
        <p><span>Staff Note:</span> {{ $quotation->staff_note }}</p>
        <p><span>Quoation Note:</span> {{ $quotation->quotation_note }}</p>
        <p><span>Total:</span> {{ $quotation->total }}</p>
        <p><span>Status:</span> {{ $quotation->status }}</p>
        <p><span>Reference Number:</span> {{ $quotation->reference_num }}</p>
        <p><span>Date Time:</span> {{ $quotation->datetime }}</p>

    </div>
@endsection
{{-- END:: detail quotation --}}

{{-- custom script --}}
@section('dashboard_script')
    
@endsection
