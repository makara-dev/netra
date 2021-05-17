@extends('layout.dashboard')

{{-- Page Title --}}
@section('page_title','Orders List')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Orders</li>
<style>
    .order-table>tbody>tr>td {
        vertical-align: middle
    }
</style>
@endsection

{{-- BEGIN:: Order Container --}}
@section('dashboard_content')
{{-- custome flash message --}}
@section('flash-message')
@if ($errors->any())
<div class="alert alert-danger">
    <p>Invalid Input!</p>
</div>
@else
@include('partials.flash-message')
@endif
@endsection

{{-- order navbar option  --}}
<div class="dropdownd-block text-right my-2">
    <button class="btn btn-gray dropdown-toggle" href="#" role="button" id="dropdownFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $filter }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownFilter">
        <a class="dropdown-item" href="{{url()->current() . '?order_status=all'}}">
            <i class="fas fa-clipboard fa-fw"></i>
            All orders
        </a>
        <a class="dropdown-item" href="{{url()->current() . '?order_status=pending'}}">
            <i class="fas fa-exclamation-circle fa-fw"></i>
            Pending orders
        </a>
        <a class="dropdown-item" href="{{url()->current() . '?order_status=confirmed'}}">
            <i class="fas fa-clipboard-check fa-fw"></i>
            Confirmed orders
        </a>
        <a class="dropdown-item" href="{{url()->current() . '?order_status=completed'}}">
            <i class="fas fa-check-circle fa-fw"></i>
            Completed orders
        </a>
        <a class="dropdown-item" href="{{url()->current() . '?order_status=cancelled'}}">
            <i class="fas fa-ban fa-fw"></i>
            Cancelled orders
        </a>
    </div>
</div>
{{-- order table wrapper  --}}
<table class="table order-table shadow-lg bg-white">
    <thead class="thead-dark thead-btn">
        <tr>
            <th>ID</th>
            <th>Order Number</th>
            <!-- <th>Customer</th> -->
            <th>Ordered Date</th>
            <th>Payment Status</th>
            <th>Delivery Status</th>
            <th>Order Status</th>
            <th>Sale Type</th>
            <th class="text-center">Options</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <input type="hidden" name="id" value="{{$order->order_id}}">
            <td>{{$order->order_id}}</td>
            <td>{{$order->order_number}}</td>
            {{-- <td>{{$order->ShippingDetail->name}}</td> --}}
            <td>{{$order->created_at->format('g:i A m/d/Y')}}</td>
            <form id="updateForm{{$order->order_id}}" action="{{ url("dashboard/orders/{$order->order_id}/edit") }}" method="POST">
                @csrf
                @method('patch')
                <input type="hidden" name="id" value="{{$order->order_id}}">
                {{-- payment status --}}
                <td>
                    <select name="paymentStatus" class="btn selectedPaymentOption
                        @switch($order->payment_status)
                            @case('cancel')
                                btn-outline-danger
                                @break
                            @case('pending')
                                btn-outline-warning
                                @break
                            @case('partial')
                                btn-outline-info
                                @break
                            @case('paid')
                                btn-outline-success
                                @break
                            @default
                                btn-outline-warning
                        @endswitch
                    ">
                        @foreach ($paymentStatuses as $class => $paymentStatus)
                        <option class="bg-light {{$class}}" value="{{$paymentStatus}}" {{($order->payment_status == $paymentStatus) ? 'selected' : ''}}>
                            {{$paymentStatus}}
                        </option>
                        @endforeach
                    </select>
                    {{-- {{logger($order->payment_status)}} --}}
                </td>
                {{-- delivery status --}}
                <td>
                    <select name="deliveryStatus" class="btn selectedDeliveryOption
                        @switch($order->delivery_status)
                            @case('cancel')
                                btn-outline-danger
                                @break
                            @case('pending')
                                btn-outline-warning
                                @break
                            @case('delivering')
                                btn-outline-info
                                @break
                            @case('delivered')
                                btn-outline-success
                                @break
                            @default
                                btn-outline-warning
                        @endswitch
                    ">
                        @foreach ($deliveryStatuses as $class => $deliveryStatus)
                        <option class="bg-light {{$class}}" value="{{$deliveryStatus}}" {{$order->delivery_status == $deliveryStatus ? 'selected' : ''}}>
                            {{$deliveryStatus}}
                        </option>
                        @endforeach
                    </select>
                    {{-- {{logger($order->delivery_status)}} --}}
                </td>
            </form>
            <td>
                @switch($order->order_status)
                @case('pending')
                <span class="text-warning font-weight-bold">Pending</span>
                @break
                @case('confirmed')
                <span class="text-primary font-weight-bold">Confirmed</span>
                @break
                @case('completed')
                <span class="text-success font-weight-bold">Completed</span>
                @break
                @case('cancelled')
                <span class="text-danger font-weight-bold">Cancelled</span>
                @break
                @default
                <span class="text-warning font-weight-bold">NaN</span>
                @endswitch
            </td>
            <td>{{$order->sale_type}}</td>
            <td class="text-center">
                <div class="btn-group">
                    {{-- update button --}}
                    @if ($order->order_status == 'confirmed' && $order->payment_status == 'paid' && $order->delivery_status == 'delivered'
                    || $order->order_status == 'completed' && $order->payment_status == 'paid' && $order->delivery_status == 'delivered')
                    <button class="btn btn-primary" disabled>
                        @else
                        <button type="submit" class="btn btn-primary" form="updateForm{{$order->order_id}}">
                            @endif
                            update
                        </button>
                        {{-- action dropdown menu --}}
                        <button type="button" class="btn btn-outline-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        {{-- dropdown-items --}}
                        <div class="dropdown-menu dropdown-menu-right">
                            {{-- detail --}}
                            <a class="dropdown-item" href="{{ url('dashboard/orders', [$order->order_id]) }}">
                                <i class="fa fa-eye fa-fw"></i>
                                Details
                            </a>
                            {{-- download pdf --}}
                            <button name="orderId" value="{{$order->order_id}}" class="dropdown-item btn btn-link" form="pdfForm{{$order->order_id}}">
                                <i class="fa fa-file-download fa-fw"></i>
                                Download PDF
                            </button>
                            {{-- confirm order --}}
                            @if ($order->order_status == 'confirmed' && $order->payment_status == 'paid' && $order->delivery_status == 'delivered'
                            ||$order->order_status == 'completed' && $order->payment_status == 'paid' && $order->delivery_status == 'delivered')
                            @elseif($order->payment_status == 'paid' && $order->delivery_status == 'delivered')
                            <form action="{{ url("dashboard/orders/{$order->order_id}/edit") }}" method="POST">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="id" value="{{$order->order_id}}">
                                <input type="hidden" name="paymentStatus" value="{{$order->payment_status}}">
                                <input type="hidden" name="deliveryStatus" value="{{$order->delivery_status}}">
                                <button name="orderStatus" value="confirmed" class="dropdown-item">
                                    <i class="fas fa-clipboard-check fa-fw"></i>
                                    Confirm order
                                </button>
                            </form>
                            @else
                            <button name="orderStatus" class="dropdown-item" style="background-color: rgb(212, 209, 209);" disabled>
                                <i class="fas fa-clipboard-check fa-fw"></i>
                                Confirm order
                            </button>
                            @endif
                            {{-- mark as complete --}}
                            @if ($order->order_status != 'pending' && $order->order_status != 'completed')
                            <form action="{{ url("dashboard/orders/{$order->order_id}/edit") }}" method="POST">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="id" value="{{$order->order_id}}">
                                <button name="orderStatus" value="completed" class="dropdown-item">
                                    <i class="fas fa-check fa-fw"></i>
                                    Mark as complete
                                </button>
                            </form>
                            @endif
                            {{-- horizontal line of dropdown --}}
                            <div class="dropdown-divider"></div>
                            {{-- cancel order --}}
                            @if ($order->order_status == 'confirmed' && $order->payment_status == 'paid' && $order->delivery_status == 'delivered'
                            ||$order->order_status == 'completed' && $order->payment_status == 'paid' && $order->delivery_status == 'delivered')
                            @else
                            <form action="{{ url("dashboard/orders/{$order->order_id}/edit") }}" method="POST">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="id" value="{{$order->order_id}}">
                                <button name="orderStatus" value="cancelled" class="dropdown-item">
                                    <i class="fas fa-ban fa-fw"></i>
                                    Cancel order
                                </button>
                            </form>
                            @endif
                            {{-- delete order --}}
                            {{-- <form id="deleteForm{{$order->order_id}}" action="{{ url('dashboard/orders', [$order->order_id]) }}"> --}}
                            <form method="POST" action="{{url('dashboard/orders/delete', [$order->order_id])}}">
                                @csrf
                                @method('Delete')
                                <button class="btn-delete dropdown-item btn btn-link">
                                    <i class="fa fa-trash fa-fw"></i>
                                    Delete order
                                </button>
                            </form>
                        </div>
                </div>
            </td>
            <form id="pdfForm{{$order->order_id}}" action="{{ url('orders/pdf') }}" method="POST">
                @csrf
            </form>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- pagination link --}}
{{ $orders->links() }}
<hr class="w-75 mx-auto">
@endsection
{{-- ENG:: Order Container --}}

@section('dashboard_script')
<script src="{{ asset('js/dashboard/order-form.js') }}"></script>
<script>
    //confirm delete 
    $('.btn-delete').on('click', function() {
        return confirm('Are you sure you want to delete selected invoice?')
    });

    $('.td-options').on('click', function(e) {
        e.stopPropagation();
    });
</script>
@endsection