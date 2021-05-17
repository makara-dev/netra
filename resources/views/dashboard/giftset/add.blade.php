@extends('layout.dashboard')

@php
    use App\Http\Controllers\Api\ApiGiftsetProductVariantController; 
@endphp

{{-- page Title --}}
@section('page_title','Add Giftset')

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
    <li class="breadcrumb-item active" aria-current="page">Giftset</li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

@section('dashboard_content')
{{-- BEGIN:: Giftset Add --}}
<section class="giftset-add-container">
    <h4 class="giftset-header-text">Comboset Information</h4>
    {{-- display input validated flash error msg --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {{-- giftset form wrapper --}}
    <form action="{{url('dashboard/giftsets/add')}}" method="POST" class="giftset-add-form-wrapper" enctype="multipart/form-data">
        @csrf
        {{-- giftset name --}}
        <div class="giftset-form-row">
            <span class="giftset-form-text">Giftset Name: </span>
            <input type="text" name="giftset-name" required>
        </div>
        {{-- giftset price --}}
        <div class="giftset-form-row">
            <span class="giftset-form-text">Giftset Price: </span>
            <input type="number" name="giftset-price" placeholder="0.00" step="0.01" min="0" value="0.00" required style="width: 3.5em!important;" oninput="this.style.width = ((this.value.length + 5) * 12) + 'px';">
            <h1 class="text-gray m-0 align-text-bottom" style="font-size: 18px;">USD</h1>
        </div>
        {{-- giftset expire date --}}
        <div class="giftset-form-row">
            <span class="giftset-form-text">Expire Date: </span>
            <input type="date" name="giftset-expireDate" required>
        </div>
        {{-- giftset total product variant selected --}}
        <div class="giftset-form-row">
            <input type="hidden" name="productVaraintArr" value="{{$productVariantArr}}">
            <span class="giftset-form-text">Total Product Selected: ({{count(json_decode($productVariantArr))}}) </span>
        </div>
        {{-- giftset thumbnail --}}
        <div id="thumbnail-add" class="giftset-form-row">
            <span class="giftset-form-text">Giftset Thumbnail</span>
            <div class="giftset-thumbnail-wrapper">
                <label for="giftset-image" class="cursor-pointer">
                    <img class="giftset-image" src="{{asset('img/product-carousel/invalid-mobile-slide.jpg')}}" alt="no-web-slide-image">
                </label>
                <input type="file" accept="image/*" name="giftset-image" id="giftset-image" class="d-none img-file-giftset" />                
            </div>
        </div>
        {{-- giftset description --}}
        <div class="giftset-form-row">
            <span class="giftset-form-text">Giftset Description</span>
            <textarea id="giftset-description" name="giftset-description" class="form-control bg-white" placeholder="Description" rows="4"></textarea>
        </div>
        {{-- next button --}}
        <div class="giftset-form-row">
            <input id="giftset-submit-btn" type="submit" class="btn btn-dark text-white ml-0 mt-2" value="Create">
        </div>
    </form>
</section>
{{-- END:: Giftset Add --}}
@endsection

@section('dashboard_script')
<script src="{{asset('js/custom-image-replicator-form.js')}}"></script>
<script>
    // check null image path before submit upload
    onUploadCheckNullImage('#giftset-submit-btn', 'giftset-image');

    // onClick set giftset thumbnail
    imageReplicator('.img-file-giftset','.giftset-image');
</script>
@endsection