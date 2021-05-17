@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/cusgroup.css')}}">
    {{-- multiple select --}}
    <link rel="stylesheet" href="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006288/BBBootstrap/choices.min.css?version=7.0.0">
    <script src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006273/BBBootstrap/choices.min.js?version=7.0.0"></script>
    
@endsection

{{-- page title --}}
@section('page_title','Customer Group Add')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('cusgroup-list')}}" class="breadcrumb-link">Customer Group</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

{{-- BEGIN:: Customer group Add --}}
@section('dashboard_content')
<div class="create-customer-content-wrapper mt-5" style="width: 90%;">
    <form id="customer-creation-form" action="{{url('dashboard/customers-group/create')}}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- general information --}}
        <div class="general-info-wrapper">
            <div class="form-row">
                {{-- customer group name --}}
                <div class="form-group col-md-4">
                    <label for="customer-name">Customer Group Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="customer-group-name" required>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- customer discount --}}
                <div class="form-group col-md-4">
                    <label for="customer-price">Customer Group Discount (%)</label>
                    <input type="number" min="0" step="any" class="form-control" name="discount" id="customer-discount" required>
                    <div id="msg"></div>
                </div>
            </div>

            {{-- customer name --}}
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="choices-multiple-remove-button">Customer Name</label>
                    <select id="choices-multiple-remove-button" name="cus-id[]" placeholder="Select customer" multiple>
                        @foreach ($customers as $customer)  
                            @if ($customer->customer_group_id == null )
                                <option value="{{$customer->customer_id}}">{{$customer->user->name}}</option>
                            @endif 
                        @endforeach
                    </select> 
                </div>
            </div>

        </div>
        {{-- add & reset button --}}
        <div class="customer-btn-wrapper form-row">
            <input type="submit" id="customer-submit" class="btn btn-submit btn-sm btn-outline-dark mr-2" value="Add customer group">
            <button id="customer-reset-btn" type="reset" class="btn btn-sm btn-outline-danger cursor-pointer">Reset</button>
        </div>
    </form>
</div>
@endsection
{{-- END:: Customer group Add --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/customer-group.js')}}"></script>
    <script>
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
        });
    </script>
@endsection
