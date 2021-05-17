@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/adjustment.css')}}">

@endsection

{{-- page title --}}
@section('page_title','Adjustment Edit')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('adjustment-list')}}" class="breadcrumb-link">Adjustment</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

{{-- BEGIN:: Adjustment Edit --}}
@section('dashboard_content')
{{-- model deleting --}}
<div id="popUpModal" class="modal">
    <div class="m-auto text-center">
        {{-- <div class="loader">Deleting</div>
        <h3>Deleting...</h3> --}}
    </div>
</div>

<div class="create-adjustment-content-wrapper mt-5" style="width: 90%;">
    <form id="adjustment-creation-form" action="{{ route('adjustment-update', ['id' => $adjustment->id]) }}" method="POST" enctype="multipart/form-data">
        @method('patch')
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
                    <input type="text" class="form-control" value="{{$adjustment->reference_no}}" name="reference_no" id="reference_no" required>
                </div>
            </div>

            <div class="form-row">
                {{-- warehouse --}}
                <div class="form-group col-md-4">
                    <label for="warehouse">Warehouse</label>
                    <input type="text" value="{{$adjustment->warehouse}}" id="warehouse" name="warehouse" class="form-control" readonly required>
                </div>

                {{-- Attach Document --}}
                <div class="form-group col-md-4">
                    <label for="document">Attach Document</label>
                    <div class="file-upload">
                        {{-- <label for="document-file-input" style="width: 100%;">
                            <small class="form-control" id="document">Browse</small>
                            <i class="fa fa-upload" aria-hidden="true"></i>
                        </label> --}}
                        <input id="document-file-input" value="{{$adjustment->document}}" name="document"  class="form-control"  type="file"/>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="productvaraint">Product Variant</label>
                    <select id="productvaraint" name="productvaraint" onchange="addProduct()" class="form-control products" placeholder="Select product" required>
                        <option selected disabled>Select product variant</option>
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

                            @foreach ($adjustment->product_variants as $key => $item)  
                                <tr>
                                    <td>{{$item->product_variant_id}}
                                        <input type="hidden" name="productvariantid[]" value="{{$item->product_variant_id}}">
                                    </td>
                                    <td>{{$item->product_variant_sku}}
                                        <input type="hidden" name="productvariant[]" value="{{$item->product_variant_sku}}">
                                    </td>
                                    <td>
                                        <select id="mySelect" name="types[]">
                                            <option value="Addition" {{ ($item->pivot->type == 'Addition') ? 'selected' : '' }}>Addition</option>
                                            <option value="Subtractions" {{ ($item->pivot->type == 'Subtractions') ? 'selected' : '' }}>Subtractions</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" id="quant" value="{{$item->pivot->quantity}}" class="quantity" name="quantity[]" onkeypress="return event.charCode >= 48" min="0">
                                    </td>
                                    <td class="text-center">
                                        <button class="btn delete-pv-btn" value="{{$item->product_variant_id}}"
                                            type="button">
                                            <i class="fas fa-trash text-gray-h cursor-pointer"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

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
                    <textarea name="note" cols="130" rows="8" style="padding: 5px 10px 5px 10px;">{{$adjustment->note}}</textarea>
                </div>
            </div>

        </div>
        {{-- add & reset button --}}
        <div class="customer-btn-wrapper form-row">
            <input type="submit" id="customer-submit" class="btn btn-submit btn-sm btn-outline-dark mr-2" value="Edit Adjustment">
            <button id="customer-reset-btn" type="reset" class="btn btn-sm btn-outline-danger cursor-pointer">Reset</button>
        </div>
    </form>
</div>

@endsection
{{-- END:: Adjustment Edit --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/adjustment.js')}}"></script>
    <script>

    $('.delete-pv-btn').on('click',function(){
        $(this).closest('tr').remove();
    })


    </script>
@endsection
