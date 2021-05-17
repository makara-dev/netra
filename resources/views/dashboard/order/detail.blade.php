@extends('layout.dashboard')

{{-- Page Title --}}
@section('page_title','Products List')
{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard/orders') }}" class="breadcrumb-link">Orders</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('dashboard_content')
<div class="container p-5">
    <h2>Receipt From Customer  [{{$shippingDetail->name}}]</h2>
    {{---------- receipt block ---------}}
    <div class="receipt-wrapper p-5 bg-white" style="border: 1px solid #707070;">
        {{-- receipt header --}}
        <div class="receipt-header" style="border-bottom: 1px solid #707070;">
            <div class="logo-wrapper text-right mb-3">
                <img style="width: 14em;" src="{{asset('icon/netra-logo.png')}}" alt="sugarxspice-logo">
            </div>
            <div class="header-text d-flex justify-content-between">
                <h5 class="font-weight-bold">RECEIPT</h5>
                <div>
                    <p style="font-size: 12px; margin-bottom: 0px;">Order Number: {{$order->order_number}}</p>
                    <p style="font-size: 12px; margin-bottom: 0px;">Order Date: {{$order->created_at}}</p>
                </div>
            </div>
            <p style="font-size: 12px;" >Your order #{{$order->order_number}} has been received</p>
        </div>

        {{-- receipt addresses --}}
        <div class="receipt-info my-4">
            <div class="user-contact-address">
                <div class="address flex-fill px-0 col-6">
                    <p class="font-weight-bold" style="border-bottom: 1px solid #707070;">DELIVERY ADDRESS</p>
                    <p>Address: {{$shippingDetail->address}}<br>Sangkat : {{$shippingDetail->sangkat_name}} <br>Khan : {{$shippingDetail->district_name}}</p>
                </div>
                <div class="bill-to flex-fill px-0 pt-3 col-6">
                    <p class="font-weight-bold" style="border-bottom: 1px solid #707070;">BILL TO</p>
                    <p>Customer Name: {{$shippingDetail->name}}</p>
                    <p>Phone Number: {{$shippingDetail->contact}}</p>
                    @if ($shippingDetail->receiver_numbers != null)
                        <p>Customer Receiver Numbers:  {{$shippingDetail->receiver_numbers}}</p>
                    @else
                        <p>Customer Receiver Numbers:  <small style="color: red;">---</small></p>
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
                        <th>PRODUCT NAME</th>
                        <th>UNIT COST</th>
                        <th>UNIT PRICE</th>
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderDetails as $key => $orderDetail)
                    <tr>
                        <td style="vertical-align: middle;">{{$key+1}}</td>
                        <td class="text-center" style="width: 25%">
                            @if ($orderDetail->thumbnail)
                            <img style="width: 45%" src="{{asset('storage/' . $orderDetail->thumbnail)}}" alt="product-image">
                            @else
                            <img style="width: 45%" src="{{asset('icon/dashboard/invalid_img.png')}}" alt="product-image">
                            @endif
                        </td>
                        <td style="vertical-align: middle;">{{$orderDetail->name}}</td>
                        <td style="vertical-align: middle;">$ {{$orderDetail->cost}}</td>
                        <td style="vertical-align: middle;">$ {{$orderDetail->price}}</td>
                        <td style="vertical-align: middle;">{{$orderDetail->quantity}}</td>
                        <td style="vertical-align: middle;">{{$orderDetail->quantity * $orderDetail->price}}</td>
                    </tr>
                    @endforeach 
                </tbody>
            </table>
            <div class="my-3" style="border-bottom: 1px solid #dfdddd;"></div>
            {{-- receipt footer --}}
            <div class="receipt-footer d-flex" style="justify-content: space-between;">
                <div class="payment-method">
                    <p class="font-weight-bold" style="border-bottom: 1px solid #707070;">
                        PAYMENT METHOD
                    </p>
                    <div class="payment-logo-wrapper">
                        @switch($order->payment_method)
                            @case('aba')
                                <img src="{{asset('icon/aba.png')}}" alt="payment-icon">
                                @break
                            @case('true money')
                                <img src="{{asset('icon/true-money.png')}}" alt="payment-icon">
                                @break
                            @case('wing')
                                <img src="{{asset('icon/wing.png')}}" alt="payment-icon">
                            @break
                            @case('pi pay')
                                <img src="{{asset('icon/pi-pay.png')}}" alt="payment-icon">
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
                    <div style="border: 1px solid #707070;"></div>
                    <p>Order Total: $ {{$order->grand_total}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('dashboard_script')
<script>
    //confirm delete 
    $('.btn-delete').on('click',function(){
        return confirm('Are you sure?') 
    });

    $('.td-options').on('click',function(e){
        e.stopPropagation();
    })
</script>
@endsection