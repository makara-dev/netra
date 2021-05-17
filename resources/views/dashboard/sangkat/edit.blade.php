@extends('layout.dashboard')


{{-- Page Title --}}
@section('page_title','Edit Sangkat')

@section('dashboard_stylesheet')
<style>
    .form-custom-input {
        width: 100%;
        max-width: 400px;
        padding: 15px;
        margin: 0 auto;
    }

    .form-custom-input .checkbox {
        font-weight: 400;
    }

    .form-custom-input .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form-custom-input .form-control:focus {
        z-index: 2;
    }

    .form-custom-input input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('dashboard/sangkats') }}" class="breadcrumb-link">Sangkats</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('dashboard_content')
<section class="container-fluid bg-white p-5 mt-2 shadow-lg">
    <form action="{{ url('dashboard/sangkats', ['id' => $sangkat->sangkat_id]) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mx-auto col-xl-5 col-lg-6 col-md-9 col-12 my-5">
            <div class="form-custom-input">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control " value="{{$sangkat->sangkat_name}}"
                        autofocus required>
                </div>
                <div class="form-group">
                    <label for="deliveryFee">Delivery Fee</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">$</span>
                        </div>
                        <input id="deliveryFee" name="deliveryFee" type="number" class="form-control" step="0.01"
                            min="0" value="{{$sangkat->delivery_fee}}" required>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-dark">Edit</button>
                </div>
            </div>
        </div>
    </form>
</section>

@endsection

@section('dashboard_script')
@endsection