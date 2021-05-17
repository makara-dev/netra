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
<li class="breadcrumb-item active" aria-current="page">Customer</li>
<li class="breadcrumb-item active" aria-current="page">List</li>
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
            <th>Email</th>
            <th>Contact</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        <tr>
            <td>{{$customer->customer_id}}</td>
            <td>{{$customer->user->name}}</td>
            <td>
                @if ($customer->user->email == null)
                    ---                   
                @endif
                {{$customer->user->email}}
            </td>
            <td>
                @if ($customer->user->contact == null)
                    ---
                @endif
                {{$customer->user->contact}}
            </td>
            <td style="display: flex; flex-direction: row; align-items: center;">
                <a class="text-dark mr-3" href="{{ url("dashboard/customers/$customer->customer_id/show") }}">
                    <i class="fas fa-info" style="color: gray;"></i>                
                </a>
                <form class="d-inline" method="POST" action="{{ url("dashboard/customers/$customer->customer_id/delete") }}"> 
                    @csrf
                    @method('delete')
                    <button  class="btn btn-delete btn-link text-gray text-gray-h p-0" type="submit">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $customers->links() }}
@endsection

@section('dashboard_script')
    <script>        
        //confirm delete customer
        $('.btn-delete').click(function(){
            return confirm('Are you sure?') 
        });
    </script>
@endsection

