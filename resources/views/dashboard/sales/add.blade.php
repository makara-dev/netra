@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/sale.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.datetimepicker.min.css')}}">
@endsection

{{-- page title --}}
@section('page_title','Sale Add')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="{{route('sale-list')}}" class="breadcrumb-link">Sale</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

{{-- BEGIN:: Sale Add --}}
@section('dashboard_content')
<div class="create-sale-content-wrapper mt-5" style="width: 90%;">
    <form id="sale-creation-form" action="{{url('dashboard/sales/create')}}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- general information --}}
        <div class="general-info-wrapper">
            {{-- datetime, reference num --}}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="datetimepicker">Date Time</label>
                    <input type="text" class="form-control" name="datetime" id="datetimepicker" readonly required>
                </div>

                <div class="form-group col-md-4">
                    <label for="reference-num">Reference Num</label>
                    <input type="text" class="form-control" name="reference-num" id="reference-num">
                </div>
            </div>
            {{-- status, payment status --}}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="sale-status">Sale Status</label>
                    <select class="form-control" name="sale-status" id="sale-status" required>
                        <option value="Pending">Pending</option>
                        <option value="Complete">Complete</option>
                        <option value="Denial">Denial</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="payment-status">Payment Status</label>
                    <select class="form-control" name="payment-status" id="payment-status" required>
                        <option value="Due">Due</option>
                        <option value="Paid">Paid</option>
                        <option value="Denial">Denial</option>
                    </select>
                </div>
            </div>
            {{-- total, paid --}}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="total">Total ($)</label>
                    <input type="number" min="1" step="any" class="form-control" name="total" id="total">
                </div>
                <div class="form-group col-md-4">
                    <label for="paid">Paid ($)</label>
                    <input type="number" min="1" step="any" class="form-control" name="paid" id="paid">
                </div>
            </div>
            {{-- sale note, staff note --}}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="sale-note">Sale Note</label>
                    <textarea class="form-control" rows="4" name="sale-note" id="sale-note"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="staff-note">Staff Note</label>
                    <textarea class="form-control" rows="4" name="staff-note" id="staff-note"></textarea>
                </div>
            </div>
            {{-- customer_id --}}
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="customer_id">Customer</label>
                    <select class="form-control" name="customer_id" id="customer_id" required>
                        @foreach($customers as $customer)
                        <option value="{{$customer->customer_id}}">{{$customer->user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- add & reset button --}}
        <div class="sale-btn-wrapper form-row">
            <input id="sale-submit" type="submit" class="btn btn-sm btn-outline-dark mr-2" value="Add sale">
            <button id="sale-reset-btn" class="btn btn-sm btn-outline-danger cursor-pointer">Reset</button>
        </div>
    </form>
</div>
@endsection
{{-- END:: Sale Add --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/sale.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
    <script>
        $('#datetimepicker').datetimepicker();
        getDate();
    </script>
@endsection