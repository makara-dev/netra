@extends('layout.dashboard')

{{-- page title --}}
@section('page_title','Dashboard')

@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/best-seller.css')}}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{url('dashboard/bestseller')}}" class="breadcrumb-link">Best Seller Product</a>
</li>
<li class="breadcrumb-item active" aria-current="page">List</li>
@endsection

@section('dashboard_content')
    <h3 class="mt-3">Best Seller Products</h3>
    <h4>Maximum 8 Product Thumbnails</h4>
    <h4 class="text-danger">(x{{8-$bestSellers->count()}}) Thumbnail left</h4>
    {{-- BEGIN:: Best Seller Product Listing --}}
    {{-- Best Seller product --}}
    <div class="best-seller-product-wrapper">
        @foreach ($bestSellers as $bestSeller)
            <div class="best-seller-wrapper">
                <div class="best-seller-img">
                    @if ($bestSeller->thumbnail == null)
                        <img style="width: 120px; height: 120px;" src="{{asset('icon/dashboard/invalid_img.png')}}" alt="invalid image">
                    @else
                        <img src="{{ asset('storage/'. $bestSeller->thumbnail) }}" alt="best seller product image">
                    @endif
                </div>
                <div class="best-seller-product-description">
                    <p class="font-weight-bolder">{{$bestSeller->productVariant->product_variant_sku}}</p>
                    <p>Color: {{$bestSeller->productVariant->attributeValues->first()->attribute_value}}</p>
                </div>
                <div class="modified-btn-wrapper">
                    <form id="btn-delete" class="form-delete bg-danger" method="POST" action="{{url('dashboard/bestseller', [$bestSeller->best_seller_id])}}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm text-white">delete</button>
                    </form>
                    {{-- change best seller product image --}}
                    <a id="btn-change" href="{{url('dashboard/bestseller/'. $bestSeller->best_seller_id .'/edit')}}" class="btn btn-sm btn-dark ml-2">change</a>
                </div>
            </div>
        @endforeach
    </div>
    {{-- add new Best Seller product --}}
    <a href="{{url('dashboard/bestseller/add')}}" class="container btn btn-outline-dark mt-3 d-flex justify-content-center">
        <img class="my-auto" src="{{asset('icon/dashboard/add.png')}}" width="20px" height="20px" alt="plus icon">
        <p class="ml-2 m-0">Add New Best Seller Product</p>
    </a>

    {{-- END:: Best Seller Product Listing --}}
@endsection

@section('dashboard_script')
    <script>        
        //confirm delete best seller product
        $('.form-delete').click(function(){
            return confirm('Are you sure to delete this product from best seller thumbnail?');
        });
    </script>
@endsection

