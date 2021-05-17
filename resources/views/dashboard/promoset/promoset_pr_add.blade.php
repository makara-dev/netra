@extends('layout.dashboard')
@php
    use App\Http\Controllers\Api\ApiGiftsetProductVariantController; 
@endphp
{{-- page Title --}}
@section('page_title','Add Giftset [Product Variants]')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap">
    <link rel="stylesheet" href="{{asset('css/dashboard/promoset.css')}}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Giftset Product Variants</li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

@section('dashboard_content')
{{-- BEGIN:: Promoset Product Variants Add --}}  
    <section class="promosetPv-add-container">
        <h4 class="promoset-header-text">Choose Special Product Variant For Giftset</h4>
        <span>[** Buy these products to get special offer **]</span>
        {{-- promoset form wrapper --}}
        <form action="{{url('dashboard/promosets/createPromoset')}}" method="POST" class="promosetPr-add-form-wrapper">
            @csrf
            <div class="promoset-pv-table-wrapper">
                <table class="promoset-table table shadow-lg bg-white mt-3">
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
                        <input type="hidden" id="productVariants" name="productVariants" value="{{ApiGiftsetProductVariantController::getTotalPaginationPage('purchasePaginationPage')}}">
                        @foreach ($productVariants as $key => $productVariant)
                            <tr class="pv-data-row cursor-pointer">
                                <td>{{$key+=1}}</td>
                                <td> <input type="checkbox" class="pv-checkbox" value="{{$productVariant->product_variant_id}}" {{ApiGiftsetProductVariantController::isChecked($currentPage,$productVariant->product_variant_id)}}> </td>
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
{{-- END:: Promoset Product Variants Add --}}
@endsection

@section('dashboard_script')
    <script src="{{asset('js/dashboard/promoset-form.js')}}"></script>
    <script>
        ApiUrl = "{!! url('api') !!}";
        ApiToken = "{!! csrf_token() !!}";

        // important variable and store number of pagination that 
        // containe array of product variants
        paginationPageName = 'purchasePaginationPage';
    </script>
@endsection