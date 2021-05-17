@extends('layout.dashboard')

@php
$idSort = app('request')->input('staff_id-sort');
$nameSort = app('request')->input('name-sort');
@endphp

{{-- page title --}}
@section('page_title','Dashboard')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">User</li>
@endsection

@section('dashboard_content')
{{-- Table --}}
<table class="table shadow-lg bg-white mt-3">
    <thead class="thead-dark thead-btn">
        <tr>
            <form id="staff_id-sort-form">
                @csrf
                <th onclick="$('#staff_id-sort-form').submit()">
                    ID
                    @if ($idSort === "desc")
                    <i class="fas fa-caret-up ml-2"></i>
                    <input type="hidden" name="staff_id-sort" value="asc">
                    @else
                    <i class="fas fa-caret-down ml-2"></i>
                    <input type="hidden" name="staff_id-sort" value="desc">
                    @endif
            </form>
            <form id="name-sort-form">
                @csrf
                <th onclick="$('#name-sort-form').submit()">
                    Name
                    @if ($nameSort === "desc")
                    <i class="fas fa-caret-up ml-2"></i>
                    <input type="hidden" name="name-sort" value="asc">
                    @else
                    <i class="fas fa-caret-down ml-2"></i>
                    <input type="hidden" name="name-sort" value="desc">
                    @endif
            </form>
            <th>Role</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($staffs as $staff)
        <tr>
            <td>{{$staff->staff_id}}</td>
            <td>{{$staff->user->name}}</td>
            <td>
                @if ($staff->is_admin)
                Admin
                <i class="fas fa-user-tie pl-2"></i>
                @else
                Staff
                @endif
            </td>
            <td>
                <a class="text-dark mr-1" href="{{ url("dashboard/staffs/$staff->staff_id/edit") }}">
                    <i class="fas fa-edit"></i>
                </a>
                <form class="d-inline" method="POST" action="{{ url("dashboard/staffs/$staff->staff_id/delete") }}"> 
                    @csrf
                    @method('delete')
                    <button  class="btn btn-delete btn-link text-gray text-gray-h p-0" type="submit"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
        <tr id="addStaffBtn"class="tr-hover-dark cursor-pointer">
            <td colspan="4" class="p-0">
                <a href="{{url('dashboard/staffs/create')}}" class="text-dark col-12 d-block p-3 text-center">
                    <u>Add a new staff</u> 
                    <i class="fas fa-user-plus pl-2"></i>
                </a>
            </td>
        </tr>
    </tbody>
</table>
{{-- {{ $staffs->links() }} --}}
@endsection

@section('dashboard_script')
    <script>        
        //confirm delete user
        $('.btn-delete').click(function(){
            return confirm('Are you sure?') 
        });
    </script>
@endsection

