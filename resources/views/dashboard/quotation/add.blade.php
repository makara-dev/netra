@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{ asset('css/dashboard/quotation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
@endsection

{{-- page title --}}
@section('page_title', 'Quotation Add')

    {{-- Breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('quotation-list') }}" class="breadcrumb-link">Quotation</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

{{-- BEGIN:: Quotation Add --}}
@section('dashboard_content')
    <div class="from-quotation-wrapper mt-5 ml-3">
        <div class="row">
            <form action="{{ route('quotation-store') }}" method="post">
                @csrf
                {{-- REFERENCE NUMBER & DATETIME --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="datetime">Datetime</label>
                        <input type="text" class="form-control" name="datetime" readonly placeholder="dd-MM-yyyy HH:mm"
                            id="datepicker">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="text">Reference Number</label>
                        <input type="text" class="form-control" name="reference_num" id="referNum">
                    </div>
                </div>

                {{-- customer_id & quotation status --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="customerSelect">Customer Name</label>
                        <select class="form-control" name="customer_id" id="customerSelect">
                            <option value="" selected>Please choose customer</option>
                            @foreach ($customers as $item)
                                <option value="{{ $item->customer_id }}">{{ $item->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="text">Quotation Status</label>
                        <select class="form-control" name="status" id="quotStatus">
                            <option value="" selected>Please choose status</option>
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                            <option value="Denail">Denail</option>
                        </select>
                    </div>
                </div>

                <p class="text-gray font-weight-bold font-18 mt-4 mb-2">Product Variant</p>
                {{-- PRODUCT & Price --}}
                <div class="form-row">
                    <div class="form-group col-md-6 productType">
                        <label for="number">Product Name</label>
                        <select class="form-control serchproduct" name="product_va_id[]" id="productvar">
                            <option value="" disabled selected>Please choose product variant...</option>
                            @foreach ($productvars as $productvar)
                                <option  value="{{ $productvar->product_variant_id }}" class="pro" productName = "{{ $productvar->product_variant_sku }}" maxQtn="{{ $productvar->quantity}}" data-price="{{ $productvar->price}}">
                                    {{ $productvar->product_variant_sku }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- price --}}
                    <div class="form-group col-md-6">
                        <label for="price">Price</label>
                        <input type="number" id="price" disabled class="form-control  price-input">
                    </div>
                </div>
               {{-- quantity --}}
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="price">Quantity</label>
                        <input type="number" max=""  class="form-control" id="quant">
                    </div>
                </div>
               
                {{-- Exchange Rate --}}
                <div class="form-row">
                    <div class="form-group col-md-12">
                        {{-- <label for="exchangerate">Exchange Rate</label> --}}
                        <select class="form-control exchangerate " hidden name="exchange_id" >
                            @foreach ($exchangerates as $exchangerate)
                                @if ($exchangerate->symbol == "R")
                                    <option value="{{ $exchangerate->id}}" data-exchange="{{ $exchangerate->currency_name}}" rate="{{$exchangerate->exchange_rate}}">{{ $exchangerate->currency_code}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
              
                {{-- btn add product to table --}}
                <section>
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            <button id="addProductVariantBtn" onclick="calCulateTotal()" class="btn btn-outline-gray py-0 px-2" type="button"
                                style="vertical-align: super">
                                <i class=" text-center fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </section>
               
                {{-- Product Variant Rows --}}
                <table class="product-variant-row-wrapper table table-borderless" id="productVariantTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product Name(Code Name)</th>
                            <th>Net Price</th>
                            <th>Quantiy</th>
                            <th>Sub Total</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- inject from js --}}
                    </tbody>
                    <tfoot >
                        <tr id="trGrandTotal">
                            <td>Total: </td>
                            <td></td>
                            <td>Quotation total in USD : $
                            </td>
                            <td id="tdtotal">
                               <p id="default">0.00</p>
                            </td>
                            <td></td>
                        </tr>
                        <tr >
                            <td></td>
                            <td></td>
                            <td class="text-danger">Quotation total in Riel : R</td>
                            <td id="rielTotal" class="text-danger">
                                <p id="default">0.00</p>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- STAFF NOTE & QUOTATION NOTE --}}
                <div class="form-row">
                    <div>
                        <label for="text">Saff Note</label>
                    </div>
                    <textarea name="staff_note" class="form-control" cols="20" rows="5"></textarea>
                    <div class="mt-3">
                        <label for="text">Quotation Note</label>
                    </div>
                    <textarea name="quotation_note" class="form-control" cols="20" rows="5"></textarea>
                </div>

                <div class="mt-3">
                    <input type="submit" class="btn btn-outline-dark" value="Add Quotation">
                    <button type="reset" class="btn btn-outline-danger cursor-pointer ml-2">Reset</button>
                </div>
            </form>
        </div>
    </div>

@endsection

{{-- custom script --}}
@section('dashboard_script')

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/quotation/quotation.js') }}"></script>
    <script src="{{ asset('js/dashboard/quotation/quotation-form.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js";></script>
 
  <script type="text/javascript">
   
        // AUTO FILL DATETIME
        var now = new Date();
        var f = now.getFullYear() + "/" +
            ('0' + (now.getMonth() + 1)).slice(-2) + "/" +
            ('0' + now.getDate()).slice(-2) + "  " +
            ('0' + now.getHours()).slice(-2) + ":" +
            ('0' + now.getMinutes()).slice(-2);
        $("#datepicker").val(f);

        $(document).ready(function() {
            $('.serchproduct').select2();
        });
    </script>
@endsection
