@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/adjustment.css')}}">

@endsection

{{-- page title --}}
@section('page_title','Adjustment Add')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('adjustment-list')}}" class="breadcrumb-link">Adjustment</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

{{-- BEGIN:: Adjustment Add --}}
@section('dashboard_content')
<div class="create-adjustment-content-wrapper mt-5" style="width: 90%;">
    <form id="adjustment-creation-form" action="{{url('dashboard/adjustment/store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- general information --}}
        <div class="general-info-wrapper">
            <div class="form-row">
                {{-- Date --}}
                <div class="form-group col-md-4">
                    <label for="datepicker">Date</label>
                    <input type="text" class="form-control" name="datetime" readonly placeholder="dd-MM-yyyy HH:mm"
                    id="datepicker" required>
                </div>

                {{-- reference no --}}
                <div class="form-group col-md-4">
                    <label for="reference_no">Reference No</label>
                    <input type="text" class="form-control" name="reference_no" id="reference_no" required>
                </div>
            </div>

            <div class="form-row">
                {{-- warehouse --}}
                <div class="form-group col-md-4">
                    <label for="warehouse">Warehouse</label>
                    <input type="text" value="Netra Store" id="warehouse" name="warehouse" class="form-control" readonly required>
                </div>

                {{-- Attach Document --}}
                <div class="form-group col-md-4">
                    <label for="document">Attach Document</label>
                    <div class="file-upload">
                        {{-- <label for="document-file-input" style="width: 100%;">
                            <small class="form-control" id="document">Browse</small>
                            <i class="fa fa-upload" aria-hidden="true"></i>
                        </label> --}}
                        <input id="document-file-input" name="document"  class="form-control"  type="file" />
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="productvaraint">Product</label>
                    <select id="productvaraint" name="productvaraint" onchange="addProduct()" class="form-control products" placeholder="Select product" required>
                        <option selected disabled>Select product</option>
                        @foreach ($productVariants as $productVariant)  
                            <option data-productvariant="{{$productVariant->product_variant_sku}}" data-product={{$productVariant->product->product_name}} value="{{$productVariant->product_variant_id}}">{{$productVariant->product_variant_sku}}</option>
                        @endforeach
                    </select> 
                </div>
            </div>

            {{-- table --}}
            <div class="form-row">
                <div class="form-group col-md-12">
                    <table class="table table-striped table-bordered table-condensed shadow-lg bg-white mt-3" id="productVariantTable">
                        <thead class="thead-dark thead-btn">
                            <tr>
                                <th>ID</th>
                                <th>Product Variant</th>
                                {{-- <th>Product Name</th> --}}
                                <th>Type</th>
                                <th>Quantiy</th>
                                <th class="text-center"><i class="fa fa-trash" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        
                            {{-- <tfoot>
                            <tr id="tfoot" class="tfoot active">
                                <th colspan="3">Total</th>
                                <th id="total"></th>
                                <th class="text-center">
                                    <i class="fa fa-trash-o" class="text-center"></i>
                                </th>
                        </tfoot> --}}

                    </table>
                </div>
            </div>

            {{-- note --}}
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="product">Note</label>
                    <textarea name="note" cols="130" rows="8" style="padding: 5px 10px 5px 10px;"></textarea>
                </div>
            </div>

        </div>
        {{-- add & reset button --}}
        <div class="customer-btn-wrapper form-row">
            <input type="submit" id="customer-submit" class="btn btn-submit btn-sm btn-outline-dark mr-2" value="Add Ajustment">
            <button id="customer-reset-btn" type="reset" class="btn btn-sm btn-outline-danger cursor-pointer">Reset</button>
        </div>
    </form>
</div>
@endsection
{{-- END:: Adjustment Add --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/adjustment.js')}}"></script>
@endsection
