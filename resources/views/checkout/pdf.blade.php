<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        header,
        body {
            font-family: sans-serif;
        }

        .border-bottom {
            border-bottom: 1px solid #707070;
        }

        .font-12 {
            font-size: 12px !important;
        }

        .font-13 {
            font-size: 13px !important;
        }

        .font-14 {
            font-size: 14px !important;
        }

        .invoice-table {
            width: 100%;
        }

        .invoice-table>thead>tr>th {
            font-size: 14px !important;
        }

        .invoice-table>tbody>tr>th {
            font-size: 13px !important;
        }
    </style>
</head>

<body>
    {{-- BEGIN::Invoice --}}
    <div class="container-fluid ">

        <div class="col-8 col-md-8 mb-1 border-bottom">
            <h5 class="font-weight-bold">Order Accepted!</h5>
        </div>
        {{---------- receipt block ---------}}
        <div class="receipt-wrapper p-1 border-bottom">
            {{-- receipt header --}}
            <div class="receipt-header border-bottom">
                <div class="logo-wrapper text-right mb-3" style="margin-top: 2em;">
                    <img style="width: 14em;"
                        src="{{'data:image/png;base64,' . base64_encode(file_get_contents(public_path('icon/netra-logo.png')))}}"
                        alt="Netra-logo">
                </div>
                <div class="header-text" style="margin-top: 2em;">
                    <span class="font-weight-bold">RECEIPT</span>
                    <div class="float-right">
                        <p class="font-12">Order Number: {{$order->order_number}}</p>
                        <p class="font-12">Order Date: {{$order->created_at}}</p>
                    </div>
                </div>
                <p style="font-size: 11px;">Your order #{{$order->order_number}} has been received</p>
            </div>

            {{-- receipt addresses --}}
            <div class="receipt-info my-2">
                <div class="user-contact-address">
                    <div class="address flex-fill px-0 col-6">
                        <p class="font-weight-bold m-0 border-bottom font-14">DELIVERY ADDRESS</p>
                        <p style="font-size: 12px;">Address: {{$shippingDetail->address}} <br>Sangkat : {{$shippingDetail->sangkat_name}} <br>Khan : {{$shippingDetail->district_name}}</p>
                    </div>
                    <div class="bill-to flex-fill px-0 col-6">
                        <p class="font-weight-bold border-bottom font-14">BILL TO</p>
                        <p class="font-13">Customer Name: {{$shippingDetail->name}}</p>
                        <p class="font-13">Phone Number: {{$shippingDetail->contact}}</p>
                        <p class="font-13">Customer Email: {{$shippingDetail->email}}</p>
                    </div>
                </div>
            </div>

            {{-- receipt body --}}
            <div class="receipt-body">
                {{-- product lists --}}
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">PRODUCT IMAGE</th>
                            <th>PRODUCT NAME</th>
                            <th>QUANTITY</th>
                            <th>UNIT PRICE</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $key => $orderDetail)
                        <tr style="margin-bottom: 1em;">
                            <td style="text-align: center" >{{$key+1}}</td>
                            <td class="text-center"style="text-align: center; width: 25%;">
                                <div style="max-height:45px">
                                    <img style="width: 45px" 
                                    @if ($orderDetail->thumbnail) 
                                        {{-- data:image/image_extension --}}
                                        src="{{'data:image/' . pathinfo(storage_path($orderDetail->thumbnail), PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(public_path('storage/' . $orderDetail->thumbnail)))}}"
                                    @else
                                        src="{{'data:image/png;base64,' . base64_encode(file_get_contents(public_path('icon/dashboard/invalid_img.png')))}}"
                                    @endif
                                    alt="product-image">
                                </div>
                            </td>
                            <td style="text-align: center">{{$orderDetail->name}}</td>
                            <td style="text-align: center">{{$orderDetail->quantity}}</td>
                            <td style="text-align: center">{{$orderDetail->price}}</td>
                            <td style="text-align: center">{{$orderDetail->price * $orderDetail->quantity}}</td>
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
                                <img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(public_path('icon/aba.png')))}}" alt="payment-icon">
                                @break
                            @case('true money')
                                <img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(public_path('icon/true-money.png')))}}" alt="payment-icon">
                                @break
                            @case('wing')
                                <img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(public_path('icon/wing.png')))}}" alt="payment-icon">
                                @break
                            @case('pi pay')
                                <img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(public_path('icon/pipay.png')))}}" alt="payment-icon">
                                @break
                            @default
                            <div>
                                <p style="font-size: 13px;">Cash On Delivery</p>
                            </div>
                            @endswitch
                        </div>
                    </div>
                    <div class="product-subtotal text-right">
                        <p>Product Subtotal: $ {{$order->total_price}}</p>
                        <p>Delivery Fees: $ {{$order->delivery_fee}}</p>
                        <p>VAT : $ {{$order->sale_tax}}</p>
                        <div style="border: 1px solid #707070;"></div>
                        <p>Order Total: $ {{$order->grand_total}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END::Invoice --}}
</body>

</html>