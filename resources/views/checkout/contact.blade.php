@extends('layout.app')

@section('title','Contact Information')

@section('stylesheet')
    @parent
    <link rel="stylesheet" href="{{asset('css/cart.css')}}">
    <link rel="stylesheet" href="{{ asset('css/custom-checkbox.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.css">
    <style>
        .round-radio label { border: none; }
        .round-radio input[type="radio"]:checked ~ label {
            background-color: unset;
            box-shadow: none;
        }
    </style>
@endsection

@section('content')
{{-- cart breadcrumb navbar *** mobile *** --}}
<div id="mobile-cart-navbar" class="col-xl-8 col-lg-7 col-12 py-lg-0 pl-lg-0">
    @include('checkout.partials.breadcrumb-nav')
</div>
{{-- cart breadcrumb navbar *** desktop *** --}}
<div id="desktop-cart-navbar" class="d-none">
    @include('checkout.partials.breadcrumb-nav')
</div>

{{-- BEGIN:: Cart Contact Information --}}
<form id="form-checkout" action="{{ action('CheckoutController@checkout') }}" method="POST">
    @csrf
    <div class="container h-100">
        <div class="row h-100 p-lg-5">
            {{-- ====== Cart Block ====== --}}
            <div class="col-lg-7 col-12 py-lg-0 pl-lg-0 custom-border">
                <div class="px-3">
                    <h5 class="font-weight-bold font-13">PLEASE FILL IN INFORMATION BELOW</h5>
                    <hr class="my-1">
                    {{-- Contact Information Block --}}
                    <div class="contact-Information-wrapper">
                        <p class="font-weight-bold my-3 font-12">1. CONTACT INFORMATION</p>
                        @if ($customer)
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="name *"
                                    value="{{$customer->name}}" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="phone (+855) *"
                                    autofocus value="{{$customer->contact}}" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="email" placeholder="email@gmail.com"
                                    value="{{$customer->email}}">
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
                                        <option value="{{$item->shipping_address_id}}">{{$item->address}}</option>
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
                            <input name="apartmentUnit" type="text" class="form-control" id="apartmentUnit" placeholder="floor / unit">
                        </div>
                        
                        {{-- destricts and sangkats --}}
                        <div class="form-row">
                            <div class="form-group form-group-lg col-md-6">
                                {{-- district ajax --}}
                                <select name="district" id="select-district" class="form-control font-12" required>
                                    <option value="0" selected>Choose District *</option>
                                    @foreach ($districts as $district)
                                        <option value="{{$district->district_id}}">{{$district->district_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group form-group-lg col-md-6">
                                <select name="sangkat" id="select-sangkat" class="form-control font-12" required>
                                    <option value="0" selected>Choose Sangkat *</option>
                                </select>
                            </div>
                        </div>

                        {{-- receiver number --}}
                        <div class="form-group">
                            <input name="receiver-numbers" type="text" class="form-control" id="receiverNumber" placeholder="receiver number (optional)">
                        </div>

                        <hr>
                        <textarea name="note" class="form-control" id="exampleFormControlTextarea1" rows="3" 
                            placeholder="additional note"></textarea>
                    </div>
                    {{-- Payment Block --}}
                    <div class="payment-method-wrapper">
                        <p class="font-weight-bold mt-3 font-12">3. PAYMENT</p>
                        @csrf
                        <p class="font-12 mb-3" style="color: gray;">Select Payment Methods</p>
                        <ul class="list-inline d-flex flex-column">
                            {{-- ABA --}}
                            <li class="mt-2 col-lg-auto col-12 px-0 my-lg-0 my-2">
                                <label for="radioAba" class="payment-collapse-btn-wrapper w-100 round-radio-wrapper">
                                    <label for="radioAba" class="btn btn-sm p-0">
                                        <img class="payment-img" style="border-radius: 10px;" src="{{ asset('icon/aba.png') }}" alt="aba" style="cursor: pointer;">
                                    </label>
                                    <small class="font-12 ml-4" style="color: gray;">ABA</small>
                                    <div class="payment-method round-radio float-right">
                                        <input id="radioAba" name="payment-methods" class="styled" type="radio" value="aba">
                                        <label for="radioAba"></label>
                                    </div>
                                </label>
                            </li>
                            {{-- Pipay --}}
                            <li class="mt-2 col-lg-auto col-12 px-0 my-lg-0 my-2">
                                <label for="radioPipay" class="payment-collapse-btn-wrapper w-100 round-radio-wrapper"> 
                                    <label for="radioPipay" class="btn btn-sm p-0">
                                        <img class="payment-img" style="cursor: pointer;" src="{{ asset('icon/pi-pay.png') }}" alt="pi pay">
                                    </label>
                                    <small class="font-12 ml-4" style="color: gray;">PIPAY</small>
                                    <div class="payment-method round-radio float-right">
                                        <input id="radioPipay" name="payment-methods" class="styled" type="radio" value="pipay">
                                        <label for="radioPipay"></label>
                                    </div>
                                </label>
                            </li>
                            {{-- Wing --}}
                            <li class="mt-2 col-lg-auto col-12 px-0 my-lg-0 my-2">
                                <label for="radioWing" class="payment-collapse-btn-wrapper w-100 round-radio-wrapper">
                                    <label for="radioWing" class="btn btn-sm p-0">
                                        <img class="payment-img" style="border-radius: 10px; cursor: pointer;" src="{{ asset('icon/wing.png') }}" alt="wing">
                                    </label>
                                    <small class="font-12 ml-4" style="color: gray;">WING</small>
                                    <div class="payment-method round-radio float-right">
                                        <input id="radioWing" name="payment-methods" class="styled" type="radio" value="wing">
                                        <label for="radioWing"></label>
                                    </div>
                                </label>
                            </li>
                            {{-- True Money --}}
                            <li class="mt-2 col-lg-auto col-12 px-0 my-lg-0 my-2">
                                <label for="radioTrueMoney" class="payment-collapse-btn-wrapper w-100 round-radio-wrapper">
                                    <label for="radioTrueMoney" class="btn btn-sm p-0">
                                        <img class="payment-img" style="border-radius: 10px; cursor: pointer;" src="{{ asset('icon/true-money.png') }}" alt="true money">
                                    </label>
                                    <small class="font-12 ml-4" style="color: gray;">TRUE MONEY</small>
                                    <div class="payment-method round-radio float-right">
                                        <input id="radioTrueMoney" name="payment-methods" class="styled" type="radio" value="true-money">
                                        <label for="radioTrueMoney"></label>
                                    </div>
                                </label>
                            </li>
                            {{-- Cash on Delivery --}}
                            <li class="mt-2 col-lg-auto col-12 px-0 my-lg-0 my-2">
                                <label for="radioCash" class="payment-collapse-btn-wrapper w-100 round-radio-wrapper">
                                    <label for="radioCash" class="btn btn-sm shadow-sm p-0">
                                        <img class="payment-img" style="border-radius: 10px; cursor: pointer;" src="{{ asset('icon/cash-on-delivery.png') }}" alt="cash on delivery">
                                    </label>
                                    <small class="font-12 ml-4" style="color: gray;">Cash on Delivery</small>
                                    <div class="payment-method round-radio float-right">
                                        <input id="radioCash" name="payment-methods" class="styled" type="radio" value="cash-on-delivery" checked>
                                        <label for="radioCash"></label>
                                    </div>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- ===== Checkout Area ==== --}}
            <div class="checkout-area-wrapper col-xl-4 col-lg-5 col-12 border-top py-lg-0 pr-lg-0 pt-3">
                <div class="checkout-area-cart rounded pt-3 px-4">
                    <h3 class="font-weight-bold font-18">Total</h3>
                    {{-- item list --}}
                    <div class="pt-3 mt-3 border-top border-bottom">
                        @foreach ($productVariants as $key => $item)
                        <div class="d-block my-3">
                            <p class="font-12">{{
                                Str::ucfirst($item->name) . ' | '.
                                $item->properties}}
                            </p>
                            <p class="font-12 text-gray ml-3"> price : 
                                <strong class="font-12 ml-2">${{$item->price}}</strong>
                            </p>
                            <p class="font-12 text-gray ml-3 mb-2"> quantity : 
                                <strong class="font-12 ml-2">{{$item->quantity}}</strong>
                            </p>
                        </div>
                        @endforeach
                    </div>
                    {{-- subtotal --}}
                    @if(!$productVariants->isEmpty())
                    <div class="pr-2 mt-3">
                        <h4 class="font-weight-bold font-15">Subtotal
                            <span class="float-right">
                                <strong>${{Cart::subtotal()}}</strong>
                            </span>
                        </h4>
                        <div class="font-12 ml-2">
                            <p class="mb-1 d-none">
                                VAT :
                                <span class="float-right">21%</span>
                            </p>
                            <p class="mb-1">
                                Discount :
                                <span class="float-right">1%</span>
                            </p>
                            <p class="mb-1">
                                Delivery Fee :
                                <span id="dilvery-fee" class="float-right text-danger">0 $</span>
                            </p>
                        </div>
                    </div>
                    @endif
                    {{-- total price --}}
                    <p class="my-2 font-weight-bold border-bottom pb-2">    
                        <input type="hidden" id="default-total" value="{{Cart::total()}}">
                        Total Price :
                        <span class="float-right text-bold">
                            $
                            <span id="total-price">
                                {{Cart::total()}}
                            </span>
                        </span>
                    </p>
                    {{-- checkout --}}
                    <button id="submit" type="submit" class="btn btn-primary mt-3 w-100 mx-auto d-block"
                        style="background-color: #691C56; color: white; border: .5px solid gray;">
                        Order Now
                    </button>
                    <div class="my-3">
                        <small>Don't have account? 
                            <a href="{{url('register')}}">click here to register!</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- END:: Cart Contact Information --}}
@endsection

@section('script')
    <script src="{{ asset('js/checkout.js') }}"></script>
    <script src="{{ asset('js/jquery.samask-masker.min.js') }}"></script>
    <script>
        ApiUrl = "{!! url('api') !!}";
        ApiToken = "{!! csrf_token() !!}";            
    </script>
@endsection