@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/sale.css')}}">
@endsection

{{-- page title --}}
@section('page_title','Sale List')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Sale</li>
@endsection

{{-- BEGIN:: Sale --}}
@section('dashboard_content')
<div class="sale-content-wrapper">
    <div class="sale-add-btn mb-2 text-right">
        <a class="btn btn-sm btn-outline-dark" href="{{ route('sale-add') }}">Create New Sale</a>
    </div>

    <table class="table shadow-lg bg-white mt-3">
        {{-- table head --}}
        <thead class="thead-dark thead-btn">
            <tr>
                <th>#Id</th>
                <th>Date Time</th>
                <th>Reference Num</th>
                <th>Sale Status</th>
                <th>Payment Status</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Sale Note</th>
                <th>Staff Note</th>
                <!-- <th>Disscount</th> -->
                <th>Action</th>
            </tr>
        </thead>
        {{-- table body --}}
        <tbody>
            @foreach ($sales as $key => $sale)
            <tr>
                <td>#{{$key+1}}</td>
                <td>{{$sale->datetime}}</td>
                <td>{{$sale->reference_num}}</td>
                <td>{{$sale->sale_status}}</td>
                <td>{{$sale->payment_status}}</td>
                <td>$ {{$sale->total}}</td>
                <td>$ {{$sale->paid}}</td>
                <td>{{$sale->sale_note}}</td>
                <td>{{$sale->staff_note}}</td>
                <!-- <td></td> -->
                <td>
                    {{-- action dropdown menu --}}
                    <img type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="{{asset('icon/dashboard/action.png')}}" alt="action icon">
                    {{-- dropdown items --}}
                    <div class="dropdown-menu dropdown-menu-left">
                        {{-- see detail --}}
                        <div class="action-see-detail-wrapper">
                            <a class="dropdown-item" href="{{ route('sale-detail', ['id' => $sale->id]) }}">See Detail</a>
                        </div>
                        {{-- edit --}}
                        <div class="action-edit-wrapper">
                            <a class="dropdown-item" href="{{url("dashboard/sales/$sale->id/edit")}}">Edit</a>
                        </div>
                        {{-- delete --}}
                        <div class="action-delete-wrapper">
                            <form action="{{ route('sale-delete', ['id' => $sale->id]) }}" method="POST">
                                @method('delete')
                                @csrf
                                <button class="sale-delete-btn dropdown-item">
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
{{-- END:: Sale --}}

{{-- custom script --}}
@section('dashboard_script')

<script>
   // show confirm delete message
   $('.sale-delete-btn').on('click', function() {
        return confirm('Do you really want to delete this sale record?');
    });
</script>
@endsection