@extends('layout.dashboard')

@php
$idSort = app('request')->input('product_id-sort');
// sku sort commming soon!
$categorySort = app('request')->input('category_name-sort');
@endphp

{{-- page title --}}
@section('page_title','Products List')

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
<li class="breadcrumb-item active" aria-current="page">Change</li>
@endsection

@section('dashboard_content')
    <h3 class="mt-3">Recommend Products</h3>
    {{-- BEGIN:: Product Listing Table --}}
    <table class="table shadow-lg bg-white mt-3">
        <thead class="thead-dark thead-btn">
            <tr>
                {{-- id --}}
                <form id="product_id-sort-form">
                    @csrf
                    <th onclick="$('#product_id-sort-form').submit()">
                        ID
                        @if ($idSort === "desc")
                        <i class="fas fa-caret-up ml-2"></i>
                        <input type="hidden" name="product_id-sort" value="asc">
                        @else
                        <i class="fas fa-caret-down ml-2"></i>
                        <input type="hidden" name="product_id-sort" value="desc">
                        @endif
                </form>
                {{-- product image --}}
                <th>Product Image</th>
                {{-- product sku --}}
                <th>Product Code / SKU</th>
                {{-- product category --}}
                <form id="category_name-sort-form">
                    @csrf
                    <th onclick="$('#category_name-sort-form').submit()">
                        Category
                        @if ($categorySort === "desc")
                        <i class="fas fa-caret-up ml-2"></i>
                        <input type="hidden" name="category_name-sort" value="asc">
                        @else
                        <i class="fas fa-caret-down ml-2"></i>
                        <input type="hidden" name="category_name-sort" value="desc">
                        @endif
                </form>
            </tr>
        </thead>
        <tbody>
            @foreach ($productVariants as $key => $productVariant)
            <tr class="table-row" onclick="location.href = '{{url('dashboard/recommend/'.$productVariant->product_variant_id.'/update/'.$recommendProduct->recommend_product_id)}}'">
                <td>{{$key+1}}</td>
                <td class="td-image-wrapper">
                    @if ($productVariant->product->thumbnail == null)
                        <img style="width: 60px; height: 60px;" src="{{asset('icon/dashboard/invalid_img.png')}}" alt="invalid image">
                    @else
                        <img src="{{ asset('storage/'. $productVariant->product->thumbnail) }}" alt="product image">
                    @endif
                </td>
                <td>{{$productVariant->product_variant_sku}}</td>
                <td>{{$productVariant->product->category->category_name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $productVariants->links() }}
    <hr class="w-75 mx-auto">
    {{-- END:: Product Listing Table --}}
@endsection

@section('dashboard_script')
@endsection

