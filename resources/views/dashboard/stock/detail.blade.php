@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/stock.css')}}">
    
@endsection

{{-- page title --}}
@section('page_title','Stock Detail')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('stock-list')}}" class="breadcrumb-link">Stock</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

{{-- BEGIN:: Stock Detail --}}
@section('dashboard_content')

<div class="adjustment-detail-container">
    <h3 id="detail-title">Adjustment Detail Info</h3>
    <div class="adjustment-detail-wrapper">
        {{-- adjustment infomations --}}
        <div class="row">
            <div class="col-4">
                @foreach ($productVariant->product->images as $item) 
                    <img src="{{ asset('storage/'. $item->path) }}" class="img-fluid mb-2" />
                    
                @endforeach
            </div>
            <div class="col-6">

                <div class="row">
                    <div class="col-6">
                        <p class="info-text">Product Variant</p>
                    </div>
                    <div class="col-6">
                        <p class="user-data">{{$productVariant->product_variant_sku}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p class="info-text">Product Name</p>
                    </div>
                    <div class="col-6">
                        <p class="user-data">{{$productVariant->product->product_name}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p class="info-text">Category Name</p>
                    </div>
                    <div class="col-6">
                        <p class="user-data">{{$productVariant->product->Category->category_name}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p class="info-text">Warehouse</p>
                    </div>
                    <div class="col-6">
                        <p class="user-data">Netra Store</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p class="info-text">Quantity</p>
                    </div>
                    <div class="col-6">
                        <p class="user-data">{{$productVariant->quantity}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p class="info-text">Cost</p>
                    </div>
                    <div class="col-6">
                        <p class="user-data">{{$productVariant->cost}} </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p class="info-text">Price</p>
                    </div>
                    <div class="col-6">
                       <p class="user-data">{{$productVariant->price}}</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <a href="{{url('dashboard/stock')}}" class="btn btn-sm btn-dark rounded align-self-end mr-5 mt-3" style="width: 70px;">
        <small style="font-size: 12px; color: white;">Done</small>
    </a> 
</div>

@endsection
{{-- END:: Stock Detail --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/stock.js')}}"></script>
@endsection