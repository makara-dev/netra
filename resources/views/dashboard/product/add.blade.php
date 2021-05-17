@extends('layout.dashboard')

{{-- Custome stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap">
    <link rel="stylesheet" href="{{ asset('css/dashboard/product-form.css') }}">
    <link rel="stylesheet" href="{{asset('css/simplemde.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('css/dashboard/product-add.css')}}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endsection

{{-- Page Title --}}
@section('page_title','Add Product')

{{-- Breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard/product') }}" class="breadcrumb-link">Product</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

@section('dashboard_content')
{{-- BEGIN:: Add Product --}}
<section class="container-fluid bg-white p-5" style="font-family: 'Source Sans Pro', sans-serif;">
    <form id="addForm" action="{{ action('ProductController@store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h4 class="text-gray d-block font-20 px-xl-5">Add Product</h4>
        {{-- Product Main Wrapper --}}
        <div class="main-product-wrapper row my-5 px-xl-5">
            <div class="main-product-image-wrapper col-xl-4 col-lg-6 col-12">
                <div class="row">
                    <div class="product-image-wrapper col-12">
                        {{-- main image --}}
                        <label for="img-file[0]" class="img-label cursor-pointer">
                            <div class="border border-dark text-center"
                                style="width: 300px; height: 400px; line-height:396px">
                                {{-- Will miss align when added Dashboard Content --}}
                                <img id="product-img" class="align-middle" src="{{ asset('icon/dashboard/upload_img.png') }}" alt="Upload Img" />
                            </div>
                        </label>
                        {{-- small product image list --}}
                        <ul class="list-unstyled row d-xl-flex d-xl- mx-0 my-2 " style="width:335px">
                            @for ($i = 0; $i < 4; $i++)
                            <li class="col-3 py-xl-3 my-lg-0 my-3 mx-xl-0 mx-lg-0 p-0">
                                <div class="img-file-wrapper">
                                    <label for="img-file[{{$i}}]">
                                        <img class="mini-img border border-dark cursor-pointer"
                                        src="{{ asset('icon/dashboard/upload_img.png') }}" alt="img" width="50px">
                                    </label>
                                    <input type="file" name="img-file[]" id="img-file[{{$i}}]" data-id="{{$i}}" accept="image/*" class="d-none img-file" />
                                </div>
                            </li>
                            @endfor
                        </ul>
                        {{-- icon wrapper --}}
                        <div class="form-group text-right" style="width:300px">
                            <label for="img-file[0]" class="img-label">
                                <a class="text-dark font-22 cursor-pointer">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </label>
                            <a class="text-dark font-22 pl-2 cursor-pointer">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- product attributes --}}
            <div class="product-variant-wrapper col-xl-8 col-lg-6 col-12 px-3">
                {{-- product name --}}
                <div class="d-block position-relative w-50">
                    <input type="text" name="productName" id="productNameInput" class="border-0 font-30 text-gray" placeholder="Item Name" required/>
                    <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                </div>
                <p class="text-gray font-weight-bold font-18 mt-4 mb-1">Product #ID</p>
                {{-- product cost --}}
                <div class="span-bottom-wrapper">
                    <span class="text-light-gray font-20 mr-5" style="padding-right: 0.35em">cost</span>
                    <div class="position-relative">
                        <div class="d-flex align-items-center">
                            <input type="number" name="cost" id="costInput" placeholder="0.00" step="0.01" min="0" value="0.00"
                                class="border-0 font-weight-bolder font-30 text-gray" style="width: 3.5em!important;"
                                oninput="this.style.width = ((this.value.length + 5) * 12) + 'px';"/>
                            <h1 class="text-gray m-0 align-text-bottom attribute-text">USD</h1>
                        </div>
                        <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                    </div>
                </div>
                {{-- product price --}}
                <div class="span-bottom-wrapper">
                    <span class="text-light-gray font-20 mr-5" style="padding-right: 0.35em">price</span>
                    <div class="position-relative">
                        <div class="d-flex align-items-center">
                            <input type="number" name="price" id="priceInput" placeholder="0.00" step="0.01" min="0" value="0.00"
                                class="border-0 font-weight-bolder font-30 text-gray" style="width: 3.5em!important;"
                                oninput="this.style.width = ((this.value.length + 5) * 12) + 'px';"/>
                            <h1 class="text-gray m-0 align-text-bottom attribute-text">USD</h1>
                        </div>
                        <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                    </div>
                </div>
                {{-- product category --}}
                <div class="span-bottom-wrapper ">
                    <label for="categorySelect" class="text-light-gray font-20 mr-5 mb-0">category</label>
                    <div class="styled-select position-relative">
                        <select class="text-gray bg-white font-30 border-0 " id="categorySelect" name="category">
                            @foreach ($categories as $category)
                            <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <p class="text-gray font-weight-bold font-18 mt-4 mb-2">Product Variant</p>
                {{-- product variants --}}
                <section class="d-table mt-3">
                    {{-- quantity input --}}
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            <div class="span-bottom-wrapper align-bottom">
                                <span class="text-light-gray font-20 mr-5" style="padding-right: 0.35em">quantity</span>
                                <div class="position-relative">
                                    <div class="d-flex align-items-center">
                                        <input type="number" name="quantityNumInput" id="quantityNumInput" value="0" min="0"
                                            class="border-0 font-weight-bolder font-30 text-gray" style="width: 3.5em!important;"
                                            oninput="this.style.width = ((this.value.length + 5) * 12) + 'px';"/>
                                        <h1 class="text-gray m-0 align-text-bottom attribute-text">Unit</h1>
                                    </div>
                                    <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- attribute values JS Injection--}}
                    <div class="d-table-row">
                        <div class="d-table-cell align-middle">
                            <div id="productVariantSelect">
                                {{-- insert from js --}}
                            </div>
                        </div>
                    </div>
                    {{-- add button --}}
                    <div class="d-table-row">
                        <div class="d-table-cell" >
                            <button id="addProductVariantBtn" class="btn btn-outline-gray py-0 px-2" type="button" style="vertical-align: super">
                                <i class=" text-center fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{-- Product Variant Rows --}}
        <table class="product-variant-row-wrapper table table-borderless" id="productVariantTable">
        </table>
        {{-- Product description --}}
        <div class="product-description-wrapper container-fluid">
            <label for="product-description" class="text-gray" style="font-size: 21px;">Item Description</label>
            <textarea id="product-description" name="description" class="form-control bg-white" placeholder="Description" rows="4"></textarea>
        </div>
        {{-- submit button --}}
        <input id="submit-btn" type="submit" class="d-block btn btn-dark ml-auto my-3" value="Add Product" name="formSubmit"/>
    </form>
</section>
{{-- END:: Add Product --}}
@endsection

@section('dashboard_script')
    {{-- <script src="{{asset('js/simplemde.js')}}"></script> --}}
    <script src="{{ asset('js/dashboard/product-form.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

    <script>
        //parse data to send to external js file
        invalidImg = {!! json_encode(asset('icon/dashboard/upload_img.png')) !!};

        apiUrl   = "{!! url('api/product/attribute') !!}"
        apiToken = "{!! csrf_token() !!}"
        simplemde = new SimpleMDE({ 
            element: document.getElementById("product-description"),
            toolbar: ["bold", "italic", "|", "unordered-list"],
            spellChecker: false
        });

        //form validation
        $("#addForm").on("submit", function(event){
            //thumbnail
            if( $('#img-file\\[0\\]').get(0).files.length == 0){
                alert("Please select an image for product");
                return false;
            }else if( $('#productVariantTableContent') && $('#productVariantTableContent').children().length <= 0 ){ //product variants
                alert("Please Add a product variant");
                return false;
            }
            return true;
        });
    </script>
@endsection