@extends('layout.dashboard')

{{-- page title --}}
@section('page_title','Customer Group List')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Customer Group</li>
@endsection

{{-- BEGIN:: Customer Group --}}
@section('dashboard_content')
    <div class="customer-content-wrapper">
        <div class="customer-add-btn mb-2" style="text-align: end;">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('cusgroup-add') }}">Create New Customer Group</a>
        </div>

        <table class="table shadow-lg bg-white mt-3">
            {{-- table head --}}
            <thead class="thead-dark thead-btn">
                <tr>
                    <th>#Id</th>
                    <th>Customer Group Name</th>
                    <th>Discount</th>
                    <th>Customers</th>
                    <th>Date Creation</th>
                    <th>Action</th>
                </tr>
            </thead>
            {{-- table body --}}
            <tbody id="myTable">
                @foreach ($customerGroups as $key => $customerGroup)
                <tr>
                    <td>#{{$key+1}}</td>
                    <td>{{$customerGroup->name}}</td>
                    <td>{{$customerGroup->discount}} %</td>
                    <td>
                        @foreach ($customerGroup->customers as $item) 
                            <li>{{$item->user->name}}</li>
                        @endforeach
                    </td>
                    <td>{{$customerGroup->created_at}}</td>
                    <td>
                        {{-- action dropdown menu --}}
                        <img type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="{{asset('icon/dashboard/action.png')}}" alt="action icon">
                        {{-- dropdown items --}}
                        <div class="dropdown-menu dropdown-menu-left">
                            {{-- see detail --}}
                            <div class="action-see-detail-wrapper">
                                <a class="dropdown-item" href="{{ route('cusgroup-detail', ['id' => $customerGroup->id]) }}">See Detail</a>
                            </div>
                            {{-- edit --}}
                            <div class="action-edit-wrapper">
                                <a class="dropdown-item" href="{{url("dashboard/customers-group/$customerGroup->id/edit")}}">Edit</a>
                            </div>
                            {{-- delete --}}
                            <div class="action-delete-wrapper">
                                <form action="{{ route('cusgroup-delete', ['id' => $customerGroup->id]) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="cusgroup-delete-btn dropdown-item">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
{{-- END:: Customers group --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/customer-group.js')}}"></script>
    
@endsection
