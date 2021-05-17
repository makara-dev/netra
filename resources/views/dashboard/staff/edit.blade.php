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
    <a href="{{ url('/dashboard/staff') }}" class="breadcrumb-link">Staff</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection


{{-- Main Dashboard Content --}}
@section('dashboard_content')
<div class="user-form-wrapper">
    <form class="user-form" action="{{route('update_staff',[$staff->staff_id])}}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <h3>User Detail Info</h3>
        <div class="user-form-body">
            <div class="user-img-wrapper">
                <label class="user-img" for="user-image">
                    @if(empty($staff->avatar))
                    <img id="user-img" class="w-100" src="{{ asset('icon/dashboard/invalid_img.png') }}" alt="upload image">
                    @else
                    <img id="user-img" class="w-100" src="{{ asset('storage/'. $staff->avatar) }}" alt="upload image">
                    @endif
                    <div class="overlay">
                        <span>Upload</span>
                    </div>
                </label>
                <input type="file" class="d-none" id="user-image"name="user-image" accept="image*">
            </div>
            <div class="form-input-group">
                <div class="form-row">
                    <label for="username">username</label>
                    <input type="text" name="username" id="username" value="{{$staff->user->name}}" required />
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
                    <input type="text" name="contact" id="contact" required value="{{$staff->user->contact}}"/>
                </div>
                <hr class="w-100" />
                <div class="custom-control custom-checkbox align-self-end pr-4 my-2">
                    @if($staff->is_admin)
                        <input type="checkbox" class="custom-control-input" id="adminCheckbox" name="admin" checked>
                    @else
                        <input type="checkbox" class="custom-control-input" id="adminCheckbox" name="admin">
                    @endif
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
