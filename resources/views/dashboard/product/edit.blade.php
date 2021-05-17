@extends('layout.dashboard')

@section('dashboard_stylesheet')
<link href="{{asset('css/simplemde.css')}}" rel="stylesheet">
<link href="{{ asset('css/dashboard/product-form.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
{{-- custom stylesheed --}}
<style>
    .loader,
    .loader:after {
        border-radius: 50%;
        width: 10em;
        height: 10em;
    }

    .loader {
        margin-bottom: 10px;
        font-size: 10px;
        position: relative;
        text-indent: -9999em;
        border-top: 1.1em solid rgba(112, 112, 112, 0.2);
        border-right: 1.1em solid rgba(112, 112, 112, 0.2);
        border-bottom: 1.1em solid rgba(112, 112, 112, 0.2);
        border-left: 1.1em solid #707070;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation: load8 1.1s infinite linear;
        animation: load8 1.1s infinite linear;
    }

    @-webkit-keyframes load8 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes load8 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    /* The Modal  */
    .modal {
        display: none;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);

        flex-direction: column;
    }
</style>
@endsection

{{-- Page Title --}}
@section('page_title','Edit Product')

{{-- Breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard/products') }}" class="breadcrumb-link">Product List</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection
{{-- loading tag when delete product --}}
@section('dashboard_content')
<div id="popUpModal" class="modal">
    <div class="m-auto text-center">
        <div class="loader">Deleting</div>
        <h3>Deleting...</h3>
    </div>
</div>
{{-- BEGIN:: Product Edit --}}
<section class="container-fluid bg-white p-5" style="font-family: 'Source Sans Pro', sans-serif;">
    <form id="updateForm" action="{{ action('ProductController@update', ['id'=> $product->product_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <h4 class="text-gray d-block font-20 px-xl-5">Add / Edit Product</h4>
        {{-- Product Main Wrapper   --}}
        <div class="main-product-wrapper row mt-5 px-xl-5">
            {{-- product images --}}
            <div class="product-image-wrapper col-xl-4 col-lg-6 col-12">
                {{-- main image --}}
                <label for="img-file[0]" class="img-label cursor-pointer">
                    <div class="border border-dark text-center" style="width: 300px; height: 400px; line-height:396px">
                        <img id="product-img" 
                            class="align-middle" 
                            src="{{ empty($product->thumbnail) ? asset('icon/dashboard/invalid_img.png') : asset('storage/'. $product->thumbnail)}}"
                            alt="product">
                    </div>
                </label>
                {{-- small product images list --}}
                <ul class="list-unstyled row d-xl-flex d-xl- mx-0 my-2 " style="width:335px">
                    @php $i = 0; @endphp
                    {{-- thumbnail--}}
                    @if ($thumbnail)
                    <li class="col-3 py-xl-3 my-lg-0 my-3 mx-xl-0 mx-lg-0 p-0">
                        <div class="img-toggler" data-toggle="collapse" href="#collapseImgBtn{{$i}}">
                            <div class="img-file-wrapper">
                                <img class="mini-img border border-dark cursor-pointer" id="miniThumbnail"
                                    src="{{ asset('storage/' . $thumbnail->path) }}" alt="img" width="50px">
                                <input type="file" name="img-file[{{$thumbnail->image_id}}]" id="img-file[{{$i}}]"
                                    data-id="{{$i}}" accept="image/*" class="d-none img-file"/>
                            </div>
                        </div>
                        <div class="collapse" id="collapseImgBtn{{$i}}">
                            <label for="img-file[{{$i}}]" class="text-dark cursor-pointer">
                                <i class="fas fa-edit"></i>
                            </label>
                            <button class="btn btn-link text-dark pl-3 cursor-pointer delete-img-btn" type="button"
                                value="{{$thumbnail->image_id}}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </li>
                    @else
                    <li class="col-3 py-xl-3 my-lg-0 my-3 mx-xl-0 mx-lg-0 p-0">
                        <div class="img-file-wrapper">
                            <label for="img-file[{{$i}}]">
                                <img class="mini-img border border-dark cursor-pointer" id="miniThumbnail"
                                    src="{{ asset('icon/dashboard/upload_img.png') }}" alt="img" width="50px">
                            </label>
                            <input type="file" name="new-img-file[]" id="img-file[{{$i}}]" data-id="{{$i}}"
                                accept="image/*" class="img-file position-absolute" style="opacity: 0" required/>
                        </div>
                    </li>
                    @endif

                    @php $i++; @endphp

                    {{-- all mini image except thumbnail --}}
                    @foreach ($images as $img)
                    @if (!$img->is_thumbnail)
                    <li class="col-3 py-xl-3 my-lg-0 my-3 mx-xl-0 mx-lg-0 p-0">
                        <div class="img-toggler" data-toggle="collapse" href="#collapseImgBtn{{$i}}">
                            <div class="img-file-wrapper">
                                <img class="mini-img border border-dark cursor-pointer"
                                    src="{{ asset('storage/' . $img->path) }}" alt="img" width="50px">
                                <input type="file" name="img-file[{{$img->image_id}}]" id="img-file[{{$i}}]"
                                    data-id="{{$i}}" accept="image/*" class="d-none img-file" />
                            </div>
                        </div>
                        <div class="collapse" id="collapseImgBtn{{$i}}">
                            <label for="img-file[{{$i}}]" class="text-dark cursor-pointer">
                                <i class="fas fa-edit"></i>
                            </label>
                            <button class="btn btn-link text-dark pl-3 cursor-pointer delete-img-btn" type="button"
                                value="{{$img->image_id}}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </li>
                    @php $i++; @endphp
                    @endif
                    @endforeach

                    @for ( ; $i < 4; $i++) 
                    <li class="col-3 py-xl-3 my-lg-0 my-3 mx-xl-0 mx-lg-0 p-0">
                            <div class="img-toggler" data-toggle="collapse" href="#collapseImgBtn{{$i}}">
                                <div class="img-file-wrapper">
                                    <img class="mini-img border border-dark cursor-pointer"
                                        src="{{ asset('icon/dashboard/upload_img.png') }}" alt="img" width="50px">
                                        <input type="file" name="new-img-file[]" id="img-file[{{$i}}]" data-id="{{$i}}"
                                        accept="image/*" class="d-none img-file" />
                                </div>
                            </div>
                            <div class="collapse" id="collapseImgBtn{{$i}}">
                                <label for="img-file[{{$i}}]" class="text-dark cursor-pointer">
                                    <i class="fas fa-edit"></i>
                                </label>
                                <button class="btn btn-link text-dark pl-3 cursor-pointer delete-img-btn" type="button" value="">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                    </li>
                    @endfor
                </ul>
            </div>
            {{-- product attributes --}}
            <div class="product-variant-wrapper col-xl-8 col-lg-6 col-12 px-3">
                {{-- product name --}}
                <div class="d-block position-relative w-50">
                    <input type="text" name="productName" id="productName" class="border-0 text-gray" placeholder="Item Name" value="{{$product->product_name}}" required />
                    <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                </div>
                <p class="text-gray font-weight-bold font-18 mt-4 mb-1">Product #ID [{{$product->product_id}}]</p>
                {{-- cost --}}
                <div class="span-bottom-wrapper">
                    <span class="text-light-gray font-20 mr-5" style="padding-right: 0.35em">cost</span>
                    <div class="position-relative">
                        <div class="d-flex align-items-center">
                            <input type="number" name="cost" id="costInput" placeholder="0.00" step="0.01" min="0"
                                value="0.00" class="border-0 font-weight-bolder font-30 text-gray"
                                style="width: 3.5em!important;"
                                oninput="this.style.width = ((this.value.length + 5) * 12) + 'px';" />
                            <h1 class="text-gray m-0 align-text-bottom attribute-text">USD</h1>
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
                                value="0.00" class="border-0 font-weight-bolder font-30 text-gray"
                                style="width: 3.5em!important;"
                                oninput="this.style.width = ((this.value.length + 5) * 12) + 'px';" />
                            <h1 class="text-gray m-0 align-text-bottom attribute-text">USD</h1>
                        </div>
                        <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                    </div>
                </div>
                {{-- category --}}
                <div class="span-bottom-wrapper ">
                    <label for="categorySelect" class="text-light-gray font-20 mr-5 mb-0">category</label>
                    <div class="styled-select position-relative">
                        <select class="text-gray bg-white font-30 border-0 " id="categorySelect" name="category"
                            disabled>
                            <option selected value="{{$category->category_id}}">{{$category->category_name}}</option>
                        </select>
                    </div>
                </div>
                {{-- product variant --}}
                <p class="text-gray font-weight-bold font-18 mt-4 mb-2">Product Variant</p>
                <section class="d-table mt-3">
                    {{-- quantity --}}
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            <div class="span-bottom-wrapper align-bottom">
                                <span class="text-light-gray font-20 mr-5" style="padding-right: 0.35em">quantity</span>
                                <div class="position-relative">
                                    <div class="d-flex align-items-center">
                                        <input type="number" name="quantityNumInput" id="quantityNumInput" value="0"
                                            min="0" class="border-0 font-weight-bolder font-30 text-gray" style="width: 3.5em !important;"
                                            oninput="this.style.width = ((this.value.length + 5) * 12) + 'px';">
                                        <h1 class="text-gray m-0 align-text-bottom attribute-text">Unit</h1>
                                    </div>
                                    <hr class="position-absolute m-0 w-100" style="bottom: 5px">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- attribute values --}}
                    <div class="d-table-row">
                        <div class="d-table-cell align-middle">
                            <div id="productVariantSelect">
                                @foreach ($category->attributes as $attr)
                                {{-- color attribute --}}
                                @if ($color != null && $attr->attribute_id == $color->attribute->attribute_id)
                                    <div class="dropdown attribute-dropdown mb-2" style="display: flex; justify-content: space-between; margin-right: 1em;">
                                        <span style="font-size: 18px; margin-right: 1em;">{{$attr->attribute_name}}</span>
                                        <button class="btn btn-sm btn-outline-gray dropdown-toggle disabled" type="button"
                                            id="{{$attr->attribute_id}}Toggler" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            {{$color->attribute_value}}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <button class="dropdown-item" value="{{$color->attribute_value_id}}"
                                                type="button">
                                                {{$color->attribute_value}}
                                            </button>
                                        </div>
                                    </div>
                                @else {{-- attributes of product variants --}}
                                    <div class="dropdown attribute-dropdown mb-2" style="display: flex; justify-content: space-between; margin-right: 1em;">
                                        <span style="font-size: 18px; margin-right: 1em;">{{$attr->attribute_name}}</span>
                                        <button class="btn btn-sm btn-outline-gray dropdown-toggle" type="button"
                                            id="{{$attr->attribute_id}}Toggler" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Select {{$attr->attribute_name}}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach ($attr->attributeValues as $attrVal)
                                            <button class="dropdown-item" value="{{$attrVal->attribute_value_id}}"
                                                type="button">
                                                {{$attrVal->attribute_value}}
                                            </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- add button --}}
                    <div class="d-table-row">
                        <div id="attribute-add-btn" class="d-table-cell">
                            <button id="addProductVariantBtn" class="btn btn-outline-gray py-0 px-2" type="button" style="vertical-align: super">
                                <i class=" text-center fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{-- Product variant table --}}
        <div class="container-fluid mt-5">
            <table class="table" id="productVariantTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Product Variant SKU</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        <th>Price</th>
                        @foreach ($category->attributes as $attr)
                        <th>{{ucfirst($attr->attribute_name)}}</th>
                        @endforeach
                        <th style="width: 30px">DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Product Variant Rows  -->
                    @foreach ($productVariants as $productVariant)
                    <tr>
                        <!-- Static product variants fields -->
                        <td>
                            <input type="text" name="productVariantSkus[{{$productVariant->product_variant_id}}]"
                                class="form-control" value="{{$productVariant->product_variant_sku}}" readonly>
                        </td>
                        <td>
                            <input type="number" name="quantities[{{$productVariant->product_variant_id}}]"
                                class="form-control" value="{{$productVariant->quantity}}" min="0">
                        </td>
                        <td>
                            <input type="number" name="costs[{{$productVariant->product_variant_id}}]"
                                class="form-control" value="{{$productVariant->cost}}" min="0" step="0.01">
                        </td>
                        <td>
                            <input type="number" name="prices[{{$productVariant->product_variant_id}}]"
                                class="form-control" value="{{$productVariant->price}}" min="0" step="0.01">
                        </td>

                        {{-- Product variants' attribute_value select  --}}
                        @foreach ($category->attributes as $attr)
                        <td>
                            {{-- if product_variant has attribute_value --}}
                            @if ($productVariant->attributeValues->contains('attribute_id', $attr->attribute_id))
                            <select class="form-control" disabled
                                name="attributeValues[{{$productVariant->product_variant_id}}][]">
                                @foreach ($attr->attributeValues as $attrVal)
                                @if ($productVariant->attributeValues->contains('attribute_value_id',
                                $attrVal->attribute_value_id))
                                <option value="{{$attrVal->attribute_value_id}}" selected>{{$attrVal->attribute_value}}
                                </option>
                                @else
                                <option value="{{$attrVal->attribute_value_id}}">{{$attrVal->attribute_value}}</option>
                                @endif
                                @endforeach
                            </select>
                            {{-- else display all attribute values  --}}
                            @else
                            <select class="form-control" disabled
                                name="attributeValues[{{$productVariant->product_variant_id}}][]" required>
                                <option selected value="">Select a new Attribute ?</option>
                                @foreach ($attr->attributeValues as $attrVal)
                                <option value="{{$attrVal->attribute_value_id}}">{{$attrVal->attribute_value}}</option>
                                @endforeach
                            </select>
                            @endif
                        </td>
                        @endforeach
                        <td>
                            <button class="btn btn-link delete-pv-btn" value="{{$productVariant->product_variant_id}}"
                                type="button">
                                <i class="fas fa-trash text-gray-h cursor-pointer"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    <!-- END :: Product Variant Rows  -->
                </tbody>
            </table>
        </div>
        {{-- Product description --}}
        <div class="product-description-wrapper container-fluid">
            <label for="product-description" class="font-30 text-gray">Item Description</label>
            <textarea id="product-description" name="description" class="form-control bg-white"
                placeholder="Description" rows="4" value="{{$product->description}}"></textarea>
        </div>
        {{-- Submit button --}}
        <input type="submit" class="d-block btn btn-dark ml-auto my-3" value="Edit Product" name="formSubmit" />
    </form>
</section>
{{-- ENG:: Product Edit --}}
@endsection

@section('dashboard_script')
    {{-- <script src="{{asset('js/simplemde.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="{{ asset('js/dashboard/product-editing-form.js') }}"></script>

    <script>
        //parse data to send to external js file
        invalidImg = {!! json_encode(asset('icon/dashboard/upload_img.png')) !!};
        description = {!! json_encode($product->description) !!};

        apiUrl   = "{!! url('api') !!}"
        apiToken = "{!! csrf_token() !!}"

        //thumbnail validation
        $("#updateForm").on("submit", function(event){
            if( $('#miniThumbnail').attr('src') == invalidImg ){
                alert("No Thumbnail Image found");
                return false;
            }
            return true;
        });

        //description
        simplemde = new SimpleMDE({ 
            element: document.getElementById("product-description"),
            toolbar: ["bold", "italic", "|", "unordered-list"],
            spellChecker: false,
        });
        if(description){
            simplemde.value(description)
        }

    </script>
@endsection