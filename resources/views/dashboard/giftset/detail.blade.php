@extends('layout.dashboard')

{{-- page Title --}}
@section('page_title','Comboset Detail')

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
    <li class="breadcrumb-item active" aria-current="page">Comboset</li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('dashboard_content')
{{-- BEGIN:: Comboset Detail --}}
<section class="giftset-detail-container">
    {{-- comboset header --}}
    <h4 class="giftset-header-text">Comboset Detail</h4>
    {{-- comboset body --}}
    <div class="giftset-detail-body-wrapper">
        {{-- comboset thumbnail and detail --}}
        <div class="giftset-info-wrapper">
            <div class="giftset-thumbnail-wrapper">
                @if ($giftset->thumbnail)
                    <img src="{{asset('storage/'.$giftset->thumbnail)}}" alt="comboset thumbnail">
                @else
                    <img src="{{asset('icon/dashboard/invalid_img.png')}}" alt="invalid comboset image">
                @endif
            </div>
            <div class="giftset-detail-info-wrapper">
                <p>Comboset Name: <span>{{$giftset->giftset_name}}</span></p>
                <p>Comboset Price: <span>{{$giftset->giftset_price}}$</span></p>
                <p>Expire Date: <span>{{$giftset->expires_at}}</span></p>
                <div class="giftset-description-wrapper">
                    <p>Comboset Description:</p>
                    <p id="description-text">{{$giftset->giftset_description}}</p>
                </div>
            </div>
            <a href="{{url('dashboard/giftsets')}}" class="btn btn-sm btn-outline-gray">Back</a>
        </div>
        {{-- comboset product variants table list --}}
        <div class="giftset-pv-table-wrapper">
            <h5>List of Product Variants Set Combination</h5>
            <small class="font-14">Product Variant Total: ({{count($productVariants)}}x)</small>
            <table class="table shadow-lg bg-white mt-3">
                <thead class="thead-dark thead-btn">
                    <th>List Id</th>
                    <th>Pv Id</th>
                    <th>Product Code / SKU</th>
                    <th>Category</th>
                </thead>
                <tbody>
                    @foreach ($productVariants as $key => $productVariant)
                        <tr class="table-row">
                            <td>{{$key+1}}</td>
                            <td>{{$productVariant->product_variant_id}}</td>
                            <td>{{$productVariant->product_variant_sku}}</td>
                            <td>{{$productVariant->product->category->category_name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
{{-- END:: Comboset Detail --}}
@endsection

@section('dashboard_script')
    <script src="{{asset('js/custom-image-replicator-form.js')}}"></script>
@endsection