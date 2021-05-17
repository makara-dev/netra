@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{ asset('css/dashboard/order.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
@endsection

{{-- page title --}}
@section('page_title', 'Order Add')

    {{-- Breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('order-list') }}" class="breadcrumb-link">Order</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

{{-- BEGIN:: Order Add --}}
@section('dashboard_content')
    <div class="from-order-wrapper mt-5 ml-3">
        <div class="row">
            <form action="{{ route('order-store') }}" method="post">
                @csrf

                {{-- PRODUCT VARIAN NAME --}}
                <div class="form-row">
                    <div class="form-group col-md-6 productType">
                        <label for="product_va_id">Product Variant</label>
                        <select class="form-control serchproduct" name="product_va_id" id="product_va_id">
                            <option value="" disabled selected>Please choose product</option>
                            @foreach ($productvars as $productvar)
                                <option value="{{ $productvar->product_variant_id }}"
                                    data-price="{{ $productvar->price }}"
                                    product_va_name="{{ $productvar->product_variant_sku }}"
                                    data-cost="{{ $productvar->cost }}" data-quantity="{{ $productvar->quantity }}">
                                    {{ $productvar->product_variant_sku }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- PRICEC & COST --}}
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="price">Price</label>
                        <input type="number" min="1" id="price" value="{{ $productvar->price }}"
                            oninput="validity.valid||(value='');" class="form-control" name="price" readonly required>
                        <input type="hidden" min="1" id="cost" value="{{ $productvar->cost }}"
                            oninput="validity.valid||(value='');" class="form-control" name="cost" readonly required>
                    </div>
                    {{-- QUANTITY --}}
                    <div class="form-group col-md-3">
                        <label for="quantity">Quantity</label>
                        <input type="hidden" min="1" step="1" name="quantity" class="form-control" id="proQuantity">
                        <input type="number" min="1" step="1" data-price="" name="quantity" class="form-control"
                            id="quantity">
                    </div>
                </div>
                <section>
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            <button id="btnAddProductVariant" class="btn btn-outline-gray py-0 px-2" type="button"
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
                            <th>Product Variant</th>
                            <th>Price($)</th>
                            <th>Cost($)</th>
                            <th>Quantiy</th>
                            <th>Total Price($)</th>
                            <th>Total Cost($)</th>
                            <th>Sub Total($)</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyRow">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total: </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <input name="totalPrice" style="visibility: hidden;" type="number" id="tdTotalPrice"
                                    readonly>
                            </td>
                            <td>
                                <input name="totalCost" style="visibility: hidden;" type="number" id="tdTotalCost" readonly>
                            </td>
                            <td>
                                <input name="grandTotal" type="number" id="tdTotal" readonly>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                {{-- <table class="mt-5 product-variant-row-wrapper table table-borderless" id="productVariantTable">
                </table> --}}

                {{-- REFERENCE NUMBER & ORDER STATUS --}}
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="reference_num">Reference Number</label>
                        <input type="text" id="reference_num" class="form-control" name="reference_num" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="order_status">Order Status</label>
                        <select class="form-control" name="order_status" id="order_status" required>
                            <option value="" selected>Please choose status</option>
                            <option value="pending">pending</option>
                            <option value="confirmed">confirmed</option>
                            <option value="completed">completed</option>
                            <option value="cancelled">cancelled</option>
                        </select>
                    </div>
                </div>

                {{-- USTOMER NAME & DELIVERY FEE --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="customer_id">Customer Name</label>
                        <select class="form-control" name="customer_id" id="customer_id" required>
                            <option value="" selected>Please choose customer</option>
                            @foreach ($customers as $item)
                                <option value="{{ $item->customer_id }}">{{ $item->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- PAYMENT METHOD --}}

                    <div class="form-group col-md-6">
                        <label for="payment_method">Payment method</label>
                        <select class="form-control" name="payment_method" id="payment_method" required>
                            <option value="" selected>Please choose method</option>
                            <option value="ABA">ABA</option>
                            <option value="PIPAY">PIPAY</option>
                            <option value="WING">WING</option>
                            <option value="TRUE MONEY">TRUE MONEY</option>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                        </select>
                    </div>
                </div>
                {{-- destricts and sangkats --}}
                <div class="form-row">
                    <div class="form-group form-group-lg col-md-6">
                        {{-- district ajax --}}
                        <select name="district" id="select-district" class="form-control font-12" required>
                            <option value="0" selected>Choose District *</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->district_id }}">{{ $district->district_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-group-lg col-md-6">
                        <select name="sangkat" id="select-sangkat" class="form-control font-12" required>
                            <option value="0" selected>Choose Sangkat *</option>
                        </select>
                    </div>
                </div>
                {{-- DELIVERY FEE & SALE TAX --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="delivery_fee">Delivery fee</label>
                        <input type="number" min="0" id="delivery_fee" oninput="validity.valid||(value='');"
                            class="form-control" name="delivery_fee" readonly required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="sale_tax">Sale tax</label>
                        <input type="number" id="sale_tax" min="0" max="9" oninput="validity.valid||(value='');"
                            class="form-control" name="sale_tax" required>
                    </div>
                </div>
                {{-- PAYMENT STATUS & DELIVERY STATUS --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="payment_status">Payment status</label>
                        <select class="form-control" id="payment_status" name="payment_status" required>
                            <option value="" selected>Please choose status</option>
                            <option value="pending">pending</option>
                            <option value="partial">partial</option>
                            <option value="paid">paid</option>
                            <option value="cancel">cancel</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="delivery_status">Delivery status</label>
                        <select class="form-control" id="delivery_status" name="delivery_status" required>
                            <option value="" selected>Please choose status</option>
                            <option value="pending">pending</option>
                            <option value="delivering">delivering</option>
                            <option value="delivered">delivered</option>
                            <option value="cancel">cancel</option>
                        </select>
                    </div>
                </div>
                {{-- Exchange rate --}}
                <div class="form-row">
                    <div class="form-group col-md-6 productType">
                        <label for="exchange_id"></label>
                        <select class="form-control" name="exchange_id" id="exchange_id">
                            <option value="">Please choose money</option>
                            @foreach ($exchangerates as $exchangerate)
                                <option value="{{ $exchangerate->id }}"
                                    data-exchange_rate="{{ $exchangerate->exchange_rate }}">
                                    {{ $exchangerate->currency_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Exchange rate --}}
                    <div class="form-group col-md-6">
                        <input type="hidden" min="0" id="exchange_rate" oninput="validity.valid||(value='');"
                            class="form-control" name="exchange_rate" readonly required>
                    </div>
                </div>

                <h5 class="font-weight-bold font-13">PLEASE FILL IN INFORMATION BELOW</h5>
                <hr class="my-1">
                {{-- Contact Information Block --}}
                <div class="contact-Information-wrapper">
                    <p class="font-weight-bold my-3 font-12">1. CONTACT INFORMATION</p>
                    @if ($customer)
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="name *"
                                value="{{ $customer->name }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="phone (+855) *"
                                autofocus value="{{ $customer->contact }}" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="email" placeholder="email@gmail.com"
                                value="{{ $customer->email }}">
                        </div>
                    @else
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="name *" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="phone (+855) *"
                                autofocus required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="email" placeholder="email@gmail.com">
                        </div>
                    @endif
                </div>

                {{-- Shipping Address Block --}}
                <div class="shipping-address-wrapper">
                    <p class="font-weight-bold my-3 font-12">2. SHIPPING ADDRESS</p>
                    {{-- address block --}}
                    @if ($shippingAddresses)
                        <h6 class="font-weight-bold">&#9679; Select a shipping address</h6>
                        <div class="form-group row">
                            <label for="shippingAddress" class="col-sm-5 col-form-label">Shipping Address</label>
                            <div class="col-sm-7">
                                <select name="shippingAddress" id="shippingAddress" class="form-control">
                                    @foreach ($shippingAddresses as $item)
                                        <option value="{{ $item->shipping_address_id }}">{{ $item->address }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-block text-right">
                            <a class="btn btn-sm btn-primary text-white">Edit Address</a>
                        </div>
                        <hr>
                        <h6 class="font-weight-bold">&#9679; Or add a new address</h6>
                    @endif
                    <div class="form-group">
                        <input name="address" type="text" class="form-control" id="address" placeholder="address">
                    </div>
                    {{-- floor --}}
                    <div class="form-group">
                        <input name="apartmentUnit" type="text" class="form-control" id="apartmentUnit"
                            placeholder="floor / unit">
                    </div>

                    {{-- receiver number --}}
                    <div class="form-group">
                        <input name="receiver-numbers" type="text" class="form-control" id="receiverNumber"
                            placeholder="receiver number (optional)">
                    </div>

                    <hr>
                    <textarea name="note" class="form-control" id="exampleFormControlTextarea1" rows="3"
                        placeholder="additional note"></textarea>
                </div>

                <div class="mt-3">
                    <input type="submit" class="btn btn-outline-dark" value="Add Order">
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
    <script src="{{ asset('js/dashboard/orders/order.js') }}"></script>
    <script src="{{ asset('js/dashboard/orders/order.min.js') }}"></script>

    <script>
        ApiUrl = "{!! url('api') !!}";
        ApiToken = "{!! csrf_token() !!}";
        // search product variant 
        $(document).ready(function() {
            $('.serchproduct').select2();
        });

    </script>
@endsection
