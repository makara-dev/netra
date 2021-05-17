@extends('layout.dashboard')

{{-- page title --}}
@section('page_title','Dashboard')

@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/featured-product.css')}}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page"> 
    <a href="{{url('dashboard/featured')}}" class="breadcrumb-link">Featured</a> 
</li>
<li class="breadcrumb-item active" aria-current="page">List</li>
@endsection

@section('dashboard_content')
    <h3 class="mt-3">Featured Products</h3>
    <h4>Maximum 4 Product Thumbnails</h4>
    <h4 class="text-danger">(x{{4-$featuredProducts->count()}}) Thumbnail left</h4>
    {{-- BEGIN:: Featured Product Listing --}}
    {{-- fetaure product --}}
    <div class="featured-product-wrapper">
        @foreach ($featuredProducts as $featuredProduct)
        <div class="featured-wrapper">
            <div class="featured-img">
                @if ($featuredProduct->thumbnail == null)
                    <img style="width: 120px; height: 120px;" src="{{asset('icon/dashboard/invalid_img.png')}}" alt="invalid image">
                @else
                    <img src="{{ asset('storage/'. $featuredProduct->thumbnail) }}" alt="featured product image">
                @endif
            </div>
            <div class="featured-product-description">
                <p class="font-weight-bolder">{{$featuredProduct->productVariant->product_variant_sku}}</p>
                <p>Color: {{$featuredProduct->productVariant->attributeValues->first()->attribute_value}}</p>
            </div>
            <div class="modified-btn-wrapper">
                <form id="btn-delete" class="form-delete bg-danger" method="POST" action="{{url('dashboard/featured', [$featuredProduct->featured_product_id])}}">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm text-white">delete</button>
                </form>
                {{-- change featured product image --}}
                <a id="btn-change" href="{{url('dashboard/featured/'. $featuredProduct->featured_product_id .'/edit')}}" class="btn btn-sm btn-dark ml-2">change</a>
            </div>
        </div>
        @endforeach
    </div>
    {{-- add new featured product --}}
    <a href="{{url('dashboard/featured/add')}}" class="container btn btn-outline-dark mt-3 d-flex justify-content-center">
        <img class="my-auto" src="{{asset('icon/dashboard/add.png')}}" width="20px" height="20px" alt="plus icon">
        <p class="ml-2 m-0">Add New Featured Product</p>
    </a>

    {{-- END:: Featured Product Listing --}}
@endsection

@section('dashboard_script')
    <script>        
        //confirm delete featured product
        $('.form-delete').click(function(){
            return confirm('Are you sure to delete this product from featured brand?');
        });
    </script>
@endsection

