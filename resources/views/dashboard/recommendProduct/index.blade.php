@extends('layout.dashboard')

{{-- page title --}}
@section('page_title','Dashboard')

@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/recommend-product.css')}}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{url('dashboard/recommend')}}" class="breadcrumb-link">Recommend Product</a>
</li>
<li class="breadcrumb-item active" aria-current="page">List</li>
@endsection

@section('dashboard_content')
<h3 class="mt-3">Recommend Products</h3>
<h4>Maximum 8 Product Thumbnails</h4>
<h4 class="text-danger">(x{{8-$recommendProducts->count()}}) Thumbnail left</h4>
    {{-- BEGIN:: Recommend Product Listing --}}
    {{-- recommend product --}}
    <div class="recommend-product-wrapper">
        @foreach ($recommendProducts as $recommendProduct)
            <div class="recommend-wrapper">
                <div class="recommend-img">
                    @if ($recommendProduct->thumbnail == null)
                        <img style="width: 120px; height: 120px;" src="{{asset('icon/dashboard/invalid_img.png')}}" alt="invalid image">
                    @else
                        <img src="{{ asset('storage/'. $recommendProduct->thumbnail) }}" alt="featured product image">
                    @endif
                </div>
                <div class="recommend-product-description">
                    <p class="font-weight-bolder">{{$recommendProduct->productVariant->product_variant_sku}}</p>
                    <p>Color: {{$recommendProduct->productVariant->attributeValues->first()->attribute_value}}</p>
                </div>
                <div class="modified-btn-wrapper">
                    <form id="btn-delete" class="form-delete bg-danger" method="POST" action="{{url('dashboard/recommend', [$recommendProduct->recommend_product_id])}}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm text-white">delete</button>
                    </form>
                    {{-- change recommend product image --}}
                    <a id="btn-change" href="{{url('dashboard/recommend/'. $recommendProduct->recommend_product_id .'/edit')}}" class="btn btn-sm btn-dark ml-2">change</a>
                </div>
            </div>
        @endforeach
    </div>
    {{-- add new recommend product --}}
    <a href="{{url('dashboard/recommend/add')}}" class="container btn btn-outline-dark mt-3 d-flex justify-content-center">
        <img class="my-auto" src="{{asset('icon/dashboard/add.png')}}" width="20px" height="20px" alt="plus icon">
        <p class="ml-2 m-0">Add New Recommend Product</p>
    </a>

    {{-- END:: Recommend Product Listing --}}
@endsection

@section('dashboard_script')
    <script>        
        //confirm delete recommend product
        $('.form-delete').click(function(){
            return confirm('Are you sure to delete this product from recommend brand?');
        });
    </script>
@endsection

