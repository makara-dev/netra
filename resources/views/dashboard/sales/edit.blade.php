@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/sale.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.datetimepicker.min.css')}}">
@endsection

{{-- page title --}}
@section('page_title','Sale Edit')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="{{route('sale-list')}}" class="breadcrumb-link">Sale</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

{{-- BEGIN:: Sale Edit --}}
@section('dashboard_content')
<div class="edit-sale-content-wrapper mt-5" style="width: 90%;">
    <form id="sale-edition-form" action="{{ route('sale-update', ['id' => $sale->id]) }}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf
        {{-- general information --}}
        <div class="general-info-wrapper">
            {{-- datetime, reference num --}}
            <div class="form-row">
                <div id="datepicker" class="form-group col-md-4">
                    <label for="datetimepicker">Date Time</label>
                    <input type="text" class="form-control" value="{{$sale->datetime}}" name="datetime" id="datetimepicker" readonly required>
                </div>

                <div class="form-group col-md-4">
                    <label for="reference-num">Reference Num</label>
                    <input type="text" class="form-control" value="{{$sale->reference_num}}" name="reference-num" id="reference-num">
                </div>
            </div>
            {{-- status, payment status --}}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="sale-status">Sale Status</label>
                    <select class="form-control" name="sale-status" id="sale-status" required>
                        <option value="Pending" @if($sale->payment_status === 'Pending') selected='selected' @endif>pending</option>
                        <option value="Complete" @if($sale->payment_status === 'Complete') selected='selected' @endif>complete</option>
                        <option value="Denial" @if($sale->payment_status === 'Denial') selected='selected' @endif>denial</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="payment-status">Payment Status</label>
                    <select class="form-control" name="payment-status" id="payment-status" required>
                        <option value="Due" @if($sale->payment_status === 'Due') selected='selected' @endif>due</option>
                        <option value="Paid" @if($sale->payment_status === 'Paid') selected='selected' @endif>paid</option>
                        <option value="Denial" @if($sale->payment_status === 'Denial') selected='selected' @endif>denial</option>
                    </select>
                </div>
            </div>
            {{-- total, paid --}}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="total">Total ($)</label>
                    <input type="number" min="1" step="any" class="form-control" value="{{$sale->total}}" name="total" id="total">
                </div>
                <div class="form-group col-md-4">
                    <label for="paid">Paid ($)</label>
                    <input type="number" min="1" step="any" class="form-control" value="{{$sale->paid}}" name="paid" id="paid">
                </div>
            </div>
            {{-- sale note, staff note --}}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="sale-note">Sale Note</label>
                    <textarea class="form-control" value="{{$sale->sale_note}}" rows="4" name="sale-note" id="sale-note">{{$sale->sale_note}}</textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="staff-note">Staff Note</label>
                    <textarea class="form-control" value="{{$sale->staff_note}}" rows="4" name="staff-note" id="staff-note">{{$sale->staff_note}}</textarea>
                </div>
            </div>
            {{-- customer id --}}
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="customer_id">Customer</label>
                    <select class="form-control" name="customer_id" id="customer_id" required>
                        @foreach($customers as $customer)
                            <option value="{{$customer->customer_id}}" @if($customer->customer_id === $sale->customer_id) selected='selected' @endif>{{$customer->user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- update button --}}
        <div class="sale-btn-wrapper form-row">
            <input id="sale-edit" type="submit" class="btn btn-sm btn-outline-dark mr-2" value="Update Sale">
        </div>
    </form>
</div>
@endsection
{{-- END:: Sale Edit --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/sale.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
    <script>
        $('#datetimepicker').datetimepicker();
    </script>
@endsection