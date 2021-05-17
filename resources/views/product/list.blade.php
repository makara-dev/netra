@extends('layout.app')

@section('title','Products Listing')

@section('stylesheet')
@parent
    <link rel="stylesheet" href="{{ asset('css/product-list.css') }}">
@endsection

@section('content')
{{-- BEGIN:: Product List --}}
    <div class="product-list-wrapper">
        {{-- filter sidebar --}}
        @include('product.partials.filter-sidebar')
        {{-- product listing wrapper --}}
        <div class="product-listing-wrapper">
            {{-- product listing card --}}
            <div class="product-listing-card-wrapper">
                @foreach($products as $product)
                <div class="product-card">
                    <a class="product-image-wrapper" href="{{ url("/products/{$product->product_id}/details") }}">
                        @if (empty($product->thumbnail))
                            <img src="{{ asset('icon/dashboard/invalid_img.png') }}" alt="product">
                        @else
                            <img src="{{ asset('storage/'. $product->thumbnail) }}" alt="product">
                        @endif
                    </a>
                    <div class="product-card-text">
                        <h6>{{$product->product_name}}</h6>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- pagination --}}
            <div class="pagination-section">
                {{ $products->links() }}
            </div>
        </div>
    </div>
{{-- END:: Product List --}}
@endsection

@section('script')
    {{-- product filter js --}}
    <script src="{{asset('js/product-filter.js')}}"></script>

    <script src="{{asset('js/custom-navbar-animation.js')}}"></script>
@endsection