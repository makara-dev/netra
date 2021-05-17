@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/stock.css')}}">
    
@endsection

{{-- page title --}}
@section('page_title','Stock')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Stock</li>
@endsection

{{-- BEGIN:: Stock --}}
@section('dashboard_content')

<div class="stock-content-wrapper">
    {{-- <div class="stock-add-btn mb-2" style="text-align: end;">
        <a class="btn btn-sm btn-outline-dark" href="{{ route('exrate-add') }}">Create New Exchange Rate</a>
    </div> --}}

    <table class="table shadow-lg bg-white mt-3">
        {{-- table head --}}
        <thead class="thead-dark thead-btn">
            <tr>
                <th>Image</th>
                <th>Product Variant</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Cost</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        {{-- table body --}}
        <tbody id="myTable">
            @foreach ($productVariants as $key => $productVariant)
            <tr>
                <td> 
                    @foreach ($productVariant->product->images as $item) 
                        <img src="{{ asset('storage/'. $item->path) }}" class="img-fluid " width="30px" height="30px"/>
                        @break
                    @endforeach
                </td>
                <td>{{$productVariant->product_variant_sku}}</td>
                <td>{{$productVariant->product->product_name}}</td>
                <td>{{$productVariant->product->Category->category_name}}</td>
                <td>{{$productVariant->cost}}</td>
                <td>{{$productVariant->price}}</td>
                <td>{{$productVariant->quantity}}</td>
                <td>
                    {{-- action dropdown menu --}}
                    <img type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="{{asset('icon/dashboard/action.png')}}" alt="action icon">
                    {{-- dropdown items --}}
                    <div class="dropdown-menu dropdown-menu-left">
                        {{-- see detail --}}
                        <div class="action-see-detail-wrapper">
                            <a class="dropdown-item" href="{{ route('stock-detail', ['id' => $productVariant->product_variant_id]) }}">See Detail</a>
                        </div>
                       
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
{{-- END:: Stock --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/stock.js')}}"></script>
@endsection