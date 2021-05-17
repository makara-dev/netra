@extends('layout.app')

@section('title','contact information')

@section('stylesheet')
@parent
<link rel="stylesheet" href="{{ asset('css/confirm-form.css') }}">
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.css">
@endsection

@section('content')
{{-- BEGIN::Confirm Form --}}
<form class="form-confirm-wrapper" action="{{ action('CheckoutController@checkoutInvoice') }}" method="GET">
    @csrf
    <input type="hidden" name="order-id" value="{{$order->order_id}}">  

    {{-- check animation --}}
    <div class="success-checkmark">
        <div class="check-icon">
          <span class="icon-line line-tip"></span>
          <span class="icon-line line-long"></span>
          <div class="icon-circle"></div>
          <div class="icon-fix"></div>
        </div>
    </div>

    {{-- confirm body --}}
    <div class="confirm-body-wrapper">
        <h3>Your Order Has Been Confirmed</h3>
        <p>Your order has been successfully processed!</p>
        {{-- payment method QR code with references number ( order number )  --}}
        <div class="payment-body-wrapper">
            <div class="payment-image-wrapper">
                @switch($order->payment_method)
                    @case('aba')
                        <img src="{{asset('img/icons/aba-qr.png')}}" alt="payment-icon" style="width: 300px;">
                    @break
                    @case('true-money')
                        <img src="{{asset('img/icons/true-money-qr.png')}}" alt="payment-icon">
                    @break
                    @case('wing')
                        <img src="{{asset('img/icons/wing-qr.png')}}" alt="payment-icon">
                    @break
                    @case('pipay')
                        <img src="{{asset('img/icons/pipay-qr.png')}}" alt="payment-icon">
                    @break
                    @default
                    <p>Cash On Delivery</p>
                @endswitch
            </div>
            <p class="font-weight-bolder">Reference Number: 
                <small class="font-weight-bold">#{{$order->order_number}}</small>
            </p>
        </div>
        <div class="confirm-btn-wrapper">
            <button class="btn" style="background-color:#691C56; color: white;">Confirm & Go To Invoice</button>
        </div>
    </div>
</form>
{{-- END::Confirm Form --}}
@endsection

@section('script')
<script>
    $(document).ready(function(){

        $(".check-icon").hide();
        setTimeout(function () {
            $(".check-icon").show();
        }, 10);

        // add and remove cart breadcrumb
        $('.node-1').removeClass('circle-node-active');
        $('.node-1').addClass('circle-node-checked');
        $('.node-2').addClass('circle-node-checked');
        
        $('.node-3').addClass('circle-node-active');
    });
</script>
@endsection