@extends('layout.dashboard')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/quotation.css')}}">
@endsection

{{-- page title --}}
@section('page_title','Quotation')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Quotation</li>
@endsection

{{-- BEGIN:: Quotation List --}}
@section('dashboard_content')
    <div class="quotation-content-wrapper">
        <div class="quotation-add-btn mb-2" style="text-align: end;">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('quotation-add') }}">Create New Quotation</a>
        </div>

        <table class="table shadow-lg bg-white mt-3 table-responsive-lg">
            {{-- table head --}}
            <thead class="thead-dark thead-btn">
                <tr>
                    <th>Date</th>
                    <th>#Id</th>
                    <th>Customer</th>
                    <th>Reference Number</th>
                    <th>Quotation Status</th>
                    <th>Quoatation Note</th>
                    <th>Staff Note</th>
                    <th>Product Name</th>
                    <th>Total In USD</th>
                    <th>Action</th>
                </tr>
            </thead>
            {{-- table body --}}
            <tbody id="data-table">
                @foreach ($quotations as $key => $quotation)
                    <tr>
                        <td>{{ $quotation->datetime }}</td>
                        <td>#{{ $key + 1 }}</td>
                        <td>
                            @if ($quotation->customer_id == null)
                                Null
                            @else
                                {{ $quotation->customer->user->name }}
                            @endif
                        </td>

                        <td>{{ $quotation->reference_num }}</td>
                        <td>{{ $quotation->status }}</td>
                        <td>{{ $quotation->quotation_note }}</td>
                        <td>{{ $quotation->staff_note }}</td>
                        <td>
                            @foreach ($quotation->productvars as $productvar)
                               {{ $productvar->product->product_name}}
                            @endforeach
                        </td>
                        <td>{{ $quotation->total}}$</td>
                        {{-- action dropdown menu --}}
                        <td>
                            <img type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" src="{{ asset('icon/dashboard/action.png') }}"
                                alt="action icon">
                            {{-- dropdown items --}}
                            <div class="dropdown-menu dropdown-menu-left">
                                {{-- see detail --}}
                                <div class="action-see-detail-wrapper">
                                    <a class="dropdown-item" href="{{ route('quotation-show', $quotation->id) }}">See
                                        Detail</a>
                                </div>
                                {{-- edit --}}
                                <div class="action-edit-wrapper">
                                    <a class="dropdown-item"
                                        href="{{ route('quotation-edit', $quotation->id) }}">Edit</a>
                                </div>
                                {{-- download as pdf --}}
                                <div>
                                    <a href="{{ route('quotation-download') }}" class="dropdown-item">Download as PDF</a>
                                </div>
                                {{-- delete --}}
                                <div class="action-delete-wrapper">
                                    <form action="{{ route('quotation-destroy', $quotation->id) }}" method="POST">
                                        @method('put')
                                        @csrf
                                        <button class="product-delete-btn dropdown-item"
                                            onclick="return confirm('Sure Want Delete?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                {{-- create to sale --}}
                                <div>
                                    <a href="{{ route('createToSale', $quotation->id) }}" class="dropdown-item">Create ToSale</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-outline-info " data-href="exportQuotation" id="export"
        onclick="exportTasks(event.target);">Export as CSV</button>
    </div>
@endsection
{{-- END:: quotation --}}

{{-- custom script --}}
@section('dashboard_script')
<script src="{{ asset('js/dashboard/quotation/quotation.js') }}"></script>
@endsection