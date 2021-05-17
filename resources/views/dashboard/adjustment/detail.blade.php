@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/adjustment.css')}}">

@endsection

{{-- page title --}}
@section('page_title','Adjustment Detail')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('adjustment-list')}}" class="breadcrumb-link">Adjustment</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

{{-- BEGIN:: Adjustment Detail --}}
@section('dashboard_content')
<div class="cusgroup-detail-container mt-5">
    <div class="cusgroup-detail-wrapper">
        <div class="row">
            <div class="col-6">
                <h4 class="detail-title">Adjustment Detail Info</h4>
                <h4 class="detail-title">Date: {{$adjustment->datetime}}</h4>
                <h4 class="detail-title">Reference No: {{$adjustment->reference_no}}</h4>
            </div>
            <div class="col-6 text-right">
                <h4 class="detail-title"></h4>
                <h4 class="detail-title">Create by: {{$adjustment->created_by}}</h4>
                <h4 class="detail-title">Date: {{$adjustment->created_at}}</h4>
            </div>
        </div>
        {{-- adjustment infomations --}}
        <div class="adjustment-info-wrapper">
            
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-bordered table-condensed shadow-lg bg-white mt-3">
                        <thead class="thead-dark thead-btn">
                            <tr>
                                <th>ID</th>
                                <th>Product Variant</th>
                                <th>Type</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($product_variants as $key => $product_variant)  
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$product_variant->product_variant_sku}}</td>
                                    <td>{{$product_variant->type}}</td>
                                    <td>{{$product_variant->quantity}}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

              
        </div>
    </div>
    <a href="{{url('dashboard/adjustment')}}" class="btn btn-sm btn-dark rounded align-self-end mt-3 float-right" style="width: 70px;">
        <small style="font-size: 12px; color: white;">Done</small>
    </a> 
</div>
@endsection
{{-- END:: Adjustment Detail --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/adjustment.js')}}"></script>
@endsection
