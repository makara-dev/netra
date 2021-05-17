@extends('layout.dashboard')

{{-- page title --}}
@section('page_title', 'Giftset Detail')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/promoset.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap">
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Giftsets</li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

{{-- BEGIN::Giftset Detail Content --}}
@section('dashboard_content')
    <section class="promoset-detail-container">
        {{-- giftset header --}}
        <h4 class="promoset-header-text">Giftsets Detail</h4>
        {{-- giftset body --}}
        <div class="promoset-detail-body-wrapper">
            {{-- giftset thumbnail and detail --}}
            <div class="promoset-info-wrapper">
                <div class="promoset-thumbnail-wrapper">
                    @if ($promoset->promoset_thumbnail)
                        <img src="{{asset('storage/'.$promoset->promoset_thumbnail)}}" alt="giftset thumbnail">
                    @else
                        <img src="{{asset('icon/dashboard/invalid_img.png')}}" alt="invalid giftset image">
                    @endif
                </div>
                <div class="promoset-detail-info-wrapper">
                    <p>Giftset Name: <span>{{$promoset->promoset_name}}</span></p>
                    <p>Created Date: <span>{{$promoset->created_at}}</span></p>
                    <div class="promoset-description-wrapper">
                        <p class="mb-4" style="margin-left: -.3em;">Giftset Description:</p>
                        <p id="description-text">{{$promoset->promoset_description}}</p>
                    </div>
                    <a href="{{url('dashboard/promosets')}}" class="btn btn-sm btn-outline-gray mt-5">Back To List</a>
                </div>
            </div>
            {{-- giftset productvariant table list --}}
            <div class="promoset-product-table-wrapper">
                {{-- purchase productvariant table list --}}
                <div class="giftset-purchasePv-table-wrapper" style="margin-bottom: 5em;">
                    <h3>List of Available Purchase Product Variants [Total: {{count($purchasePvs)}}x]</h3>
                    <p>Condition Description: [ Purchase {{$promoset->promoset_condition}} of below product variants to get free giftset ]</p>
                    <table class="table shadow-lg bg-white mt-4">
                        <thead class="thead-dark thead-btn">
                            <th>Pv Id</th>
                            <th>Product Code / SKU</th>
                            <th>Category</th>
                        </thead>
                        <tbody>
                            @foreach ($purchasePvs as $key => $purchasePv)
                                <tr class="table-row">
                                    <td>{{$purchasePv->product_variant_id}}</td>
                                    <td>{{$purchasePv->product_variant_sku}}</td>
                                    <td>{{$purchasePv->product->category->category_name}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- free productvariant table list --}}
                <div class="giftset-freePv-table-wrapper">
                    <h3>List of Available Free Product Variants Giftset</h3>
                    <p>Condition Description: [ Get Free {{$promoset->provider_condition}} pairs out of {{count($freePvs)}}x of below product variants listing ]</p>
                    <table class="table shadow-lg bg-white mt-4">
                        <thead class="thead-dark thead-btn">
                            <th>Pv Id</th>
                            <th>Product Code / SKU</th>
                            <th>Category</th>
                        </thead>
                        <tbody>
                            @foreach ($freePvs as $key => $freePv)
                                <tr class="table-row">
                                    <td>{{$freePv->product_variant_id}}</td>
                                    <td>{{$freePv->product_variant_sku}}</td>
                                    <td>{{$freePv->product->category->category_name}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
{{-- END::Giftset Detail Content --}}

{{-- script section --}}
@section('dashboard_script')
<script>
    
</script>   
@endsection