@extends('layout.dashboard')
@php
    use App\Http\Controllers\Api\ApiGiftsetProductVariantController; 
@endphp
{{-- page Title --}}
@section('page_title','Add Comboset [Product Variants]')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap">
    <link rel="stylesheet" href="{{asset('css/dashboard/giftset.css')}}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Comboset Product Variants</li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

@section('dashboard_content')
{{-- BEGIN:: Giftset Product Variants Add --}}  
<section class="giftset-add-container">
    <h4 class="giftset-header-text">Choose Product Variant For Comboset</h4>
    {{-- giftset form wrapper --}}
    <form action="{{url('dashboard/giftsets/createGiftset')}}" method="POST" class="giftsetPr-add-form-wrapper">
        @csrf
        <div class="giftset-pv-table-wrapper">
            <table class="giftset-table table shadow-lg bg-white mt-3">
                <thead class="thead-dark thead-btn">
                    <tr>
                        <th>ID</th>
                        <th>Check</th>
                        <th>Product Variant SKU</th>
                        <th>Category</th>
                        <th>Stock Quantity</th>
                        <th>Product Price</th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" id="productVariants" name="productVariants" value="{{ApiGiftsetProductVariantController::getTotalPaginationPage('paginationPage')}}">
                    @foreach ($productVariants as $key => $productVariant)
                        <tr class="pv-data-row cursor-pointer">
                            <td>{{$key+=1}}</td>
                            <td> <input type="checkbox" class="pv-checkbox" value="{{$productVariant->product_variant_id}}" {{ApiGiftsetProductVariantController::isChecked($currentPage,$productVariant->product_variant_id)}}>  </td>
                            <td>{{$productVariant->product_variant_sku}}</td>
                            <td>{{$productVariant->product->category->category_name}}</td>
                            <td>{{$productVariant->quantity}}</td>
                            <td>{{$productVariant->price}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $productVariants->links() }}
        <div class="btn-submit-wrapper">
            <input id="submit-btn" type="submit" class="btn btn-dark text-white ml-0 mt-2" value="Next">
        </div>
    </form>
</section>
{{-- END:: Giftset Product Variants Add --}}
@endsection

@section('dashboard_script')
<script src="{{asset('js/dashboard/giftset-form.js')}}"></script>
<script>
    ApiUrl = "{!! url('api') !!}";
    ApiToken = "{!! csrf_token() !!}";
</script>
@endsection