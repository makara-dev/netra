@extends('layout.dashboard')

@php
    use App\Http\Controllers\Api\ApiGiftsetProductVariantController; 
@endphp

{{-- page title --}}
@section('page_title', 'Add Giftset [Product Variants]')

{{-- custom style --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/promoset.css')}}">
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Giftsets</li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

{{-- main content --}}
@section('dashboard_content')
    {{-- BEGIN::Add Promoset --}}
    <h3 class="mt-3">Giftsets Add</h3>
    {{-- adding form block --}}
    <div class="promoset-add-container">
        {{-- promoset thumbnail --}}
        <div id="promoset-add" class="promoset-add-thumbnail-wrapper">
            <span class="promoset-form-text">Giftset Thumbnail ( required * )</span>
            <div class="promoset-thumbnail-wrapper">
                <label for="promoset-image" class="cursor-pointer">
                    <img id="image-path" class="promoset-image" src="{{asset('img/product-carousel/invalid-mobile-slide.jpg')}}" alt="no-web-slide-image">
                </label>
                <input type="file" accept="image/*" name="promoset-image" id="promoset-image" class="d-none img-file-promoset" />                
            </div>
        </div>
        {{-- promoset infomation --}}
        <div class="promoset-add-info-wrapper">
            {{-- promoset name --}}
            <div class="promoset-add-info-row">
                <span class="promoset-add-info-text">Giftset Name: 
                    <input id="promoset-name" type="text" placeholder="required *">
                </span>
            </div>
            {{-- promoset condition --}}
            <div class="promoset-add-info-row"> 
                <span class="promoset-add-info-text">Set Condition: </span>
                <input type="hidden" id="totalPurchasePv" value="{{count(json_decode($purchsePvArr))}}">
                <p>Purchase 
                    <input id="promoset-purchase-number" type="number" class="num-input" min="1" placeholder="0" value="1" onkeypress="return event.charCode >= 48">
                    of previous selected products [Total: {{count(json_decode($purchsePvArr))}}x]
                </p>
            </div>
            {{-- promoset provider --}}
            <div class="promoset-add-info-row"> 
                <span class="promoset-add-info-text">Set Provider: </span>
                <input type="hidden" id="freePvProviders" value='[]'>
                <p>Get free
                    <input id="promoset-free-number" type="number" class="num-input" name="set-condition" min="1" placeholder="0" value="1" onkeypress="return event.charCode >= 48">
                    pairs of [Total: <span id="totalFreePvId" class="font-weight-light">0</span>]
                    <a class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#freePvModal">choose product</a>
                </p>
            </div>
            {{-- promoset discount offer --}}
            <div class="promoset-add-info-row" style="flex-flow: row wrap; align-items: center;"> 
                <input type="checkbox" id="discount-checkbox" name="discount-offer">
                <span id="offer-text" class="promoset-add-info-text">offer discount price? </span>
                <input type="number" id="offer-input" name="discount-price-offer" class="num-input d-none" value="1" placeholder="0.00"> ($ OFF)
            </div>
            {{-- promoset description --}}
            <div class="promoset-add-info-row mt-3">
                <span class="promoset-add-info-text">Promoset Description: </span>
                <textarea id="promoset-description" name="promoset-description" class="form-control bg-white" placeholder="Description" rows="4" style="border: .5px solid gray;"></textarea>
            </div>
            {{-- promoset add button --}}
            <div class="promoset-add-info-row align-content-end">
                <button class="btn btn-sm btn-outline-dark" id="promosetAddBtn">+</button>
            </div>
        </div>
    </div>
    {{-- displaying data table block --}}
    <div class="promoset-data-table-container">
        <form action="{{url('dashboard/promosets/add')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="purchasePvArr" value="{{$purchsePvArr}}">
            {{-- promoset set table listing --}}
            <table class="table shadow-lg bg-white mt-3">
                <thead class="thead-dark thead-btn promoset-thead">
                    <tr>
                        <th>Giftset Name</th>
                        <th>Condition (Purchase)</th>
                        <th>Total Set Products</th>
                        <th>Condition (Free)</th>
                        <th>Total Free Products</th>
                        <th>Discount Offer</th>
                        <th>Thumbnail</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody id="list-set-body">
                    {{-- Js Injection --}}
                </tbody>
            </table>
            {{-- create button --}}
            <div>
                <input class="btn btn-sm btn-outline-dark" type="submit" value="Create">
            </div>
        </form>
    </div>
    {{-- provider product variants modal table --}}
    <div id="freePvModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="freePvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- modal header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="freePvModalLabel">Select Free Product Variants</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer pb-0">
                    <button type="button" class="btn btn-outline-dark modalDoneBtn">Done</button>
                </div>
                <!-- modal body -->
                <div class="modal-body">
                    <input type="hidden" id="temp-free-pv-arr" value="[]">
                    <table class="promoset-table table shadow-lg bg-white mt-3">
                        <thead class="thead-dark thead-btn">
                            <tr>
                                <th>ID</th>
                                <th>Check</th>
                                <th>Product Variant SKU</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productVariants as $key => $productVariant)
                                <tr class="pv-data-row cursor-pointer">
                                    <td>{{$key+=1}}</td>
                                    <td> <input id="pvFreeCheckbox{{$key}}" type="checkbox" class="pv-checkbox" value="{{$productVariant->product_variant_id}}"> </td>
                                    <td>{{$productVariant->product_variant_sku}}</td>
                                    <td>{{$productVariant->product->category->category_name}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- modal footer where all buttons represent -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger modalCancelBtn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-dark modalDoneBtn">Done</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END::Add Promoset --}}
@endsection

{{-- script section --}}
@section('dashboard_script')
<script src="{{asset('js/custom-image-replicator-form.js')}}"></script>
<script src="{{asset('js/dashboard/promoset-form.js')}}"></script>
<script>
    // onClick set giftset thumbnail
    imageReplicator('.img-file-promoset','.promoset-image');

    // onCheckbox check enalbe or disable discount price input
    onCheckboxCheckEnableDiscountPrice('#discount-checkbox', '#offer-text', '#offer-input');

    // onClick add promoset btn create list of promoset table.
    onClickCreatePromosetListTable( "#promosetAddBtn", 
                                    "promoset-image", 
                                    "#promoset-name", 
                                    "#promoset-purchase-number", 
                                    "#promoset-free-number", 
                                    "#offer-input", 
                                    "#promoset-description",
                                    "#freePvProviders",
                                );
    onFreePvRowClickedAddProductVariantArr();
    modelConfirmBtn('.modalDoneBtn','.modalCancelBtn');
</script>   
@endsection