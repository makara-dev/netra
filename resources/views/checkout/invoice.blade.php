@extends('layout.app')

@section('title','contact information')

@section('stylesheet')
@parent
<link rel="stylesheet" href="{{ asset('css/custom-checkbox.css') }}">
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.css">
@endsection

@section('content')
{{-- cart breadcrumb narvbar *** mobile ***--}}
<div id="mobile-cart-navbar" class="col-xl-8 col-lg-7 col-12 py-lg-0 pl-lg-0">
    @include('checkout.partials.breadcrumb-nav')
</div>
{{-- cart breadcrumb narvbar *** desktop ***--}}
<div id="desktop-cart-navbar" class="d-none">
    @include('checkout.partials.breadcrumb-nav')
</div>

{{-- BEGIN::Invoice --}}
<div class="Invoice">
    {{-- download pdf form --}}
    <form id="downloadPdf" action="{{ url('orders/pdf') }}" method="POST">
        @csrf
        <input type="hidden" name="orderId" value="{{$order->order_id}}">
    </form>
    {{-- invoice wrapper --}}
    <div class="container invoice-wrapper">
        <div class="my-3 mx-3" style="border-bottom: 1px solid #707070;">
            <h3 class="invoice-status-text font-weight-bold">Your Order Is Completed!</h3>
        </div>
        {{---------- receipt block ---------}}
        <div class="receipt-wrapper px-2 py-3" style="border: 1px solid #707070;">
            {{-- receipt header --}}
            <div class="receipt-header mt-2" style="border-bottom: 1px solid #707070;">
                <div class="logo-wrapper text-right mb-2">
                    <img style="width: 14em;" src="{{asset('icon/netra.svg')}}" alt="Netra-logo">
                </div>
                <div class="header-text d-flex justify-content-between">
                    <h5 class="font-weight-bold">RECEIPT</h5>
                    <div>
                        <p>Order Number: {{$order->order_number}}</p>
                        <p>Order Date: {{$order->created_at}}</p>
                    </div>
                </div>
                <p>Your order #{{$order->order_number}} has been received</p>
            </div>
            {{-- receipt addresses --}}
            <div class="receipt-info my-3">
                <div class="user-contact-address">
                    <div class="address flex-fill px-0 col-6">
                        <p class="address-text font-weight-bold mb-2" style="border-bottom: 1px solid #707070;">DELIVERY ADDRESS</p>
                        <p >Address: {{$shippingDetail->address}} <br>Sangkat : {{$shippingDetail->sangkat_name}} <br>Khan : {{$shippingDetail->district_name}}</p>
                    </div>
                    <div class="bill-to flex-fill px-0 pt-3 col-6">
                        <p class="bill-text font-weight-bold mb-2" style="border-bottom: 1px solid #707070;">BILL TO</p>
                        <p>Customer Name:  {{$shippingDetail->name}}</p>
                        <p>Phone Number:   {{$shippingDetail->contact}}</p>
                        @if ($shippingDetail->receiver_numbers != null)
                            <p>Customer Receiver Numbers:  {{$shippingDetail->receiver_numbers}}</p>
                        @endif
                        <p>Customer Email: {{$shippingDetail->email}}</p>
                    </div>
                </div>
            </div>
            {{-- receipt body --}}
            <div class="receipt-body">
                {{-- product lists --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">PRODUCT IMAGE</th>
                            <th style="text-align: center">PRODUCT NAME</th>
                            <th>QTY</th>
                            <th>UNIT PRICE</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $key => $orderDetail)
                        <tr>
                            <td style="vertical-align: middle;">{{$key+1}}</td>
                            <td class="text-center td-img-wrapper">
                                @if ($orderDetail->thumbnail)
                                    <img src="{{asset('storage/'.$orderDetail->thumbnail)}}" alt="product-image">
                                @else
                                    <img src="{{asset('icon/dashboard/invalid_img.png')}}" alt="product-image">
                                @endif
                            </td>
                            <td style="vertical-align: middle; text-align: center">{{$orderDetail->name}}</td>
                            <td style="vertical-align: middle;">{{$orderDetail->quantity}}</td>
                            <td style="vertical-align: middle;">$ {{$orderDetail->price}}</td>
                            <td style="vertical-align: middle;">$ {{$orderDetail->price * $orderDetail->quantity}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-2" style="border-bottom: 1px solid #dfdddd;"></div>
                {{-- receipt footer --}}
                <div class="receipt-footer d-flex" style="justify-content: space-between;">
                    <div class="payment-method">
                        <p class="font-weight-bolder" style="border-bottom: 1px solid #707070;">
                            PAYMENT METHOD
                        </p>
                        <div class="payment-logo-wrapper">
                            @switch($order->payment_method)
                            @case('aba')
                                <div class="payment-image-wrapper">
                                    <img src="{{asset('icon/aba.png')}}" alt="payment-icon">
                                </div>
                            @break
                            @case('true-money')
                                <div class="payment-image-wrapper">
                                    <img src="{{asset('icon/true-money.png')}}" alt="payment-icon">
                                </div>
                            @break
                            @case('wing')
                                <div class="payment-image-wrapper">
                                    <img src="{{asset('icon/wing.png')}}" alt="payment-icon">
                                </div>
                            @break
                            @case('pipay')
                                <div class="payment-image-wrapper">
                                    <img src="{{asset('icon/pi-pay.png')}}" alt="payment-icon">
                                </div>
                            @break
                            @default
                            <div>
                                <p>Cash On Delivery</p>
                            </div>
                            @endswitch
                        </div>
                    </div>
                    <div class="product-subtotal text-right">
                        <p>Product Subtotal: $ {{$order->total_price}}</p>
                        <p>Delivery Fees: $ {{$order->delivery_fee}}</p>
                        <p>VAT : $ {{$order->sale_tax}}</p>
                        <div class="my-1" style="border: 1px solid #707070;"></div>
                        <p>Order Total: $ {{$order->grand_total}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-block">
            <a href="{{route('home')}}" class="btn-return-home btn float-right bg-pink my-2">Return To Homepage</a>
        </div>
    </div>
</div>
{{-- END::Invoice --}}
@endsection

@section('script')
<script>
    $(document).ready(function(){
        var isConfirm = confirm("Do you want to download a pdf copy of this order?");
        if(isConfirm) {
            $('#downloadPdf').submit();
        }

        // add and remove cart breadcrumb
        $('.node-1').removeClass('circle-node-active');
        $('.node-1').addClass('circle-node-checked');
        $('.node-2').addClass('circle-node-checked');
        
        $('.node-3').addClass('circle-node-active');
    });
</script>
@endsection