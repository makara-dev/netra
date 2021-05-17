@extends('layout.dashboard')

{{-- Stylesheet --}}
@section('dashboard_stylesheet')
<link rel="stylesheet" href="{{ asset('css/dashboard/staff-form.css') }}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard/staffs') }}" class="breadcrumb-link">Staff</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection


{{-- Main Dashboard Content --}}
@section('dashboard_content')
<div class="user-form-wrapper">
    <form class="user-form" action="{{url('dashboard/staffs/create')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>User Detail Info</h3>
        <div class="user-form-body">
            <div class="user-img-wrapper">
                <label class="user-img" for="user-image">
                    <img id="user-img" class="w-100" src="{{ asset('icon/dashboard/upload_img.png') }}" alt="upload image">
                    <div class="overlay">
                        <span>Upload</span>
                    </div>
                </label>
                <input type="file" class="d-none" id="user-image" name="user-image" accept="image*">
            </div>
            <div class="form-input-group">
                <div class="form-row">
                    <label for="username">username</label>
                    <input type="text" name="username" id="username" required />
                </div>
                <div class="form-row ">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required  minlength="6"/>
                </div>
                <div class="form-group">
                    <div class="form-row position-relative mb-0">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required minlength="6"/>
                    </div>
                    <small class="d-block text-right" id="message" class="form-text text-muted"></small>
                </div>
                <div class="form-row ">
                    <label for="contact">Contact</label>
                    <input type="text" name="contact" id="contact" required />
                </div>
                <hr class="w-100" />
                <div class="custom-control custom-checkbox align-self-end pr-4 my-2">
                    <input type="checkbox" class="custom-control-input" id="adminCheckbox" name="admin">
                    <label class="custom-control-label text-dark font-16" for="adminCheckbox">Admin</label>
                </div>

            </div>
        </div>
        <hr class="w-100">
        <ul class="list-inline list-unstyled w-100 text-right pt-2">
            <li class="list-inline-item">
                <button id="formSubmit" type="submit" class="btn btn-dark">Save</button>
            </li>
            <li class="list-inline-item">
                <button class="btn btn-dark">Close</button>
            </li>
        </ul>
    </form>
</div>
@endsection

@section('dashboard_script')
<script src="{{ asset('js/dashboard/staff-form.js') }}"></script>
@endsection
