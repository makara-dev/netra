@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/cusgroup.css')}}">
    {{-- multiple select --}}
    <link rel="stylesheet" href="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006288/BBBootstrap/choices.min.css?version=7.0.0">
    <script src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006273/BBBootstrap/choices.min.js?version=7.0.0"></script>
    
@endsection

{{-- page title --}}
@section('page_title','Customer Group Edit')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{route('cusgroup-list')}}" class="breadcrumb-link">Customer Group</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

{{-- BEGIN:: Customer Group Edit --}}
@section('dashboard_content')
<div class="edit-customer-content-wrapper mt-5" style="width: 90%;">
    <form id="customer-edition-form" action="{{ route('cusgroup-update', ['id' => $customerGroup->id]) }}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf
        {{-- general information --}}
        <div class="general-info-wrapper">
            <div class="form-row">
                {{-- customer group name --}}
                <div class="form-group col-md-4">
                    <label for="customer-name">Customer Name</label>
                    <input type="text" value="{{$customerGroup->name}}" class="form-control @error('name') is-invalid @enderror" name="name" id="customer-group-name" required>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- customer discount --}}
                <div class="form-group col-md-4">
                    <label for="customer-price">Customer Group Discount (%)</label>
                    <input type="number" min="0" step="any" value="{{$customerGroup->discount}}" class="form-control" name="discount" id="customer-discount" required>
                </div>
            </div>

            {{-- customer name --}}
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="choices-multiple-remove-button">Customer Name</label>
                    <select id="choices-multiple-remove-button" name="cus-id[]" placeholder="Select customer" multiple>
                        <?php
                            $selected = array();
                            foreach ($customerGroup->customers as $item){
                                $selected[] = $item->customer_id;
                            }
                        ?>
                        @foreach ($customers as $item)
                            <option value="{{ $item->customer_id }}" {{ (in_array($item->customer_id, $selected)) ? 'selected' : '' }}>{{ $item->user->name}}</option>
                        @endforeach
                    </select> 
                </div>
            </div>

        </div>

        {{-- add & reset button --}}
        <div class="customer-btn-wrapper form-row">
            <input type="submit" id="customer-submit" class="btn btn-sm btn-outline-dark mr-2" value="Update customer group">
            <a href="/dashboard/customers-group" class="btn btn-sm btn-outline-danger mr-2">Back</a>
        </div>
    </form>
</div>
@endsection
{{-- END:: Customer Group Edit --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/customer-group.js')}}"></script>
    <script>
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
        });
    </script>
@endsection
