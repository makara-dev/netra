@extends('layout.dashboard')

@section('dashboard_stylesheet')
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
<link href="{{ asset('css/dashboard/product-form.css') }}" rel="stylesheet">
<link href="{{asset('css/simplemde.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endsection

{{-- Page Title --}}
@section('page_title','Add Product Variant')

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
<section class="container-fluid bg-white p-5" style="font-family: 'Source Sans Pro', sans-serif;">
    <form action="{{ action('ProductController@store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h4 class="text-gray d-block font-20 px-xl-5">Add Product</h4>
        <!-- ============================================================== -->
        <!-- Product Main Wrapper  -->
        <!-- ============================================================== -->
        <div class="row my-5 px-xl-5">
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="row">
                    <div class="col-12">
                            {{-- main image --}}

                            <label for="img-file[0]" class="img-label cursor-pointer">
                                <div class="border border-dark text-center"
                                    style="width: 300px; height: 400px; line-height:396px">
                                    @if (empty($product->thumbnail))
                                        <img id="product-img" class="align-middle" src="{{ asset('icon/dashboard/invalid_img.png') }}" alt="product">
                                    @else
                                        <img id="product-img" class="align-middle" src="{{ asset('storage/'. $product->thumbnail) }}" alt="product">
                                    @endif
                                </div>
                            </label>
                            {{-- small image list --}}
                            <ul class="list-unstyled row d-xl-flex d-xl- mx-0 my-2 " style="width:335px">
                                <?php $count = 0; ?>
                                @foreach ($product->images as $img)
                                <li class="col-3 py-xl-3 my-lg-0 my-3 mx-xl-0 mx-lg-0 p-0">
                                    <div class="img-file-wrapper">
                                        <div>
                                            <img class="mini-img border border-dark cursor-pointer"
                                            src="{{ asset('storage/' . $img->path) }}" alt="img" width="50px">
                                            <input type="file" name="img-file[]" id="img-file[{{$i}}]" data-id="{{$i}}" accept="image/*" class="d-none img-file" />
                                        </div>
                                    </div>
                                </li> 
                                <?php $count++; ?>
                                @endforeach
                                @for ($i = $count; $i < 4; $i++)
                                <li class="col-3 py-xl-3 my-lg-0 my-3 mx-xl-0 mx-lg-0 p-0">
                                    <div class="img-file-wrapper">
                                        if()
                                        <label for="img-file[{{$i}}]">
                                            <img class="mini-img border border-dark cursor-pointer"
                                            src="{{ asset('icon/dashboard/upload_img.png') }}" alt="img" width="50px">
                                        </label>
                                        <input type="file" name="img-file[]" id="img-file[{{$i}}]" data-id="{{$i}}" accept="image/*" class="d-none img-file" />
                                    </div>
                                </li>
                                @endfor
                            </ul>
                    </div>
                </div>
            </div>
            {{-- product attributes --}}
            <div class="col-xl-8 col-lg-6 col-12 px-3">
                {{-- product name --}}
                <div class="d-block position-relative w-50">
                    <input type="text" name="productName" id="productNameInput" class="border-0 font-30 text-gray"
                        placeholder="Item Name" required/>
                    <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                </div>

                <p class="text-gray font-weight-bold font-18 mt-4 mb-1">Product #ID</p>
                {{-- cost --}}
                <div class="span-bottom-wrapper">
                    <span class="text-light-gray font-20 mr-5" style="padding-right: 0.35em">cost</span>
                    <div class="position-relative">
                        <div class="d-flex align-items-center">
                            <input type="number" name="cost" id="costInput" placeholder="0.00" step="0.01" min="0"
                                class="border-0 font-weight-bolder font-30 text-gray" style="width: 2.5em!important;"
                                oninput="this.style.width = ((this.value.length + 2) * 12) + 'px';"/>
                            <h1 class="text-gray m-0 align-text-bottom">USD</h1>
                        </div>
                        <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                    </div>
                </div>
                {{-- price --}}
                <div class="span-bottom-wrapper">
                    <span class="text-light-gray font-20 mr-5" style="padding-right: 0.35em">price</span>
                    <div class="position-relative">
                        <div class="d-flex align-items-center">
                            <input type="number" name="price" id="priceInput" placeholder="0.00" step="0.01" min="0"
                                class="border-0 font-weight-bolder font-30 text-gray" style="width: 2.5em!important;"
                                oninput="this.style.width = ((this.value.length + 2) * 12) + 'px';"/>
                            <h1 class="text-gray m-0 align-text-bottom">USD</h1>
                        </div>
                        <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                    </div>
                </div>
                {{-- category --}}
                <div class="span-bottom-wrapper ">
                    <label for="categorySelect" class="text-light-gray font-20 mr-5 mb-0">category</label>
                    <div class="styled-select position-relative">
                        <select class="text-gray bg-white font-30 border-0 " id="categorySelect" name="categorySelect">
                            @foreach ($categories as $category)
                            <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <p class="text-gray font-weight-bold font-18 mt-4 mb-2">Product Variant</p>
                
                <section class="d-table mt-3">
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            <div class="span-bottom-wrapper align-bottom">
                                <span class="text-light-gray font-20 mr-5" style="padding-right: 0.35em">quantity</span>
                                <div class="position-relative">
                                    <div class="d-flex align-items-center">
                                        <input type="number" name="quantityNumInput" id="quantityNumInput" value="0" min="0"
                                            class="border-0 font-weight-bolder font-30 text-gray"
                                            oninput="this.style.width = ((this.value.length + 2) * 12) + 'px';">
                                        <h1 class="text-gray m-0 align-text-bottom">Unit</h1>
                                    </div>
                                    <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                                </div>
                            </div>
                        </div>
                        {{-- attribute values --}}
                        <div class="d-table-cell align-middle">
                            <div id="productVariantSelect">
                                {{-- insert from js --}}
                            </div>
                        </div>
                        <div class="d-table-cell" >
                            <button id="addProductVariantBtn" class="btn btn-outline-gray py-0 px-2" type="button" style="vertical-align: super">
                                <i class=" text-center fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Product Wrapper  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Product Variant Rows  -->
        <!-- ============================================================== -->
        <table class="table table-borderless" id="productVariantTable">

        </table>
        <!-- ============================================================== -->
        <!-- End :: Product Variant Rows  -->
        <!-- ============================================================== -->

        {{-- product description --}}
        <div class="container-fluid">
            <label for="product-description" class="font-30 text-gray">Item Description</label>
            <textarea id="product-description" name="description" class="form-control bg-white" placeholder="Description" rows="4"></textarea>
        </div>
        
        <input type="submit" class="d-block btn btn-dark ml-auto my-3" value="Add Product" name="formSubmit"/>


    </form>
</section>
@endsection

@section('dashboard_script')
{{-- <script src="{{asset('js/simplemde.js')}}"></script> --}}
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

<script>
    //parse data to send to external js file
    invalidImg = {!! json_encode(asset('icon/dashboard/invalid_img.png')) !!}

    apiUrl   = "{!! url('api/product/attribute') !!}"
    apiToken = "{!! csrf_token() !!}"
    simplemde = new SimpleMDE({ 
        element: document.getElementById("product-description"),
        toolbar: ["bold", "italic", "|", "unordered-list"],
        spellChecker: false
     });
</script>
<script src="{{ asset('js/dashboard/product-form.js') }}"></script>
@endsection