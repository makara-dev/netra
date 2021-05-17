@extends('layout.dashboard')

@section('dashboard_stylesheet')
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
@endsection

{{-- Page Title --}}
@section('page_title','Add Product')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard/product') }}" class="breadcrumb-link">Attribute</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

@section('dashboard_content')
<section class="container-fluid bg-white p-5 mt-2 shadow-lg">
    <div class="mx-auto col-xl-5 col-lg-6 col-md-9 col-12 my-5">
        <label class="font-16">Add a new attribute</label>
        <form action="{{ action('Dashboard\AttributeController@store') }}" method="POST">
            @csrf
            <div class="input-group">
                <input name="attribute" type="text" class="form-control" placeholder="Attribute" aria-label="Attribute">
                <div class="input-group-append mb-3">
                    <input type="hidden" name="category">
                    <button type="submit" class="btn btn-outline-gray">Create</button>
                    <button id="categoryBtn" type="button" class="btn btn-outline-gray dropdown-toggle dropdown-toggle-split "
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mx-2">Select Category</span>
                    </button>
                   
                    <div id="categoryDropdown" class="dropdown-menu" >
                        @foreach ($categories as $item)
                        <button type="button" class="dropdown-item" value="{{$item->category_id}}" >{{$item->category_name}}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>


        <form action="{{ action('Dashboard\AttributeValueController@store') }}" method="POST">
            @csrf
            <div class="form-group">
                <div class="dropdown">
                    <label class="font-16 d-block">Or select from one</label>
                    <button id="attributeDropdownBtn" type="button" class="btn btn-outline-gray dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="">
                        Select an attribute
                    </button>
                    <input type="hidden" name="attribute">
                    <div id="attributeDropdown" class="dropdown-menu" aria-labelledby="attributeDropdownBtn">
                        @foreach ($attributes as $attribute)
                        <a class="dropdown-item cursor-pointer"
                            data-value="{{$attribute->attribute_id}}">{{$attribute->attribute_name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- attribute value input --}}
            <div id="attributeValueWrapper" class="form-group d-none">
                <label class="font-16">
                    Add attribute value
                </label>
                <div class="input-group mb-3 col-12">
                    <input name="attributeValueInput" id="attributeValueInput" type="text" class="form-control"
                        placeholder="Attribute">
                    <div class="input-group-append">
                        <button id="addAttributeValueBtn" type="button" class="btn btn-outline-gray">Add</button>
                    </div>
                </div>


                <table id="attributeValueTable" class="table shadow-soft mt-5">
                    <thead>
                        <tr>
                            <th class="table-dark">#</th>
                            <th class="th-name table-dark" class="table-dark">Attribute Values</th>
                            <th class="table-dark">option</th>
                        </tr>
                    </thead>
                    <tbody id="attributeValueTbody" class="text-center attribute-value-tbody">
                    </tbody>
                </table>
                <button type="submit" class="btn btn-dark float-right">Create</button>
        </form>
    </div>
</section>
@endsection

@section('dashboard_script')
<script src="{{ asset('js/dashboard/attribute-form.js') }}"></script>
@endsection