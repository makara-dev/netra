@extends('layout.dashboard')

{{-- page title --}}
@section('page_title','Adjustment')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Adjustment</li>
@endsection

{{-- BEGIN:: Adjustment --}}
@section('dashboard_content')
    <div class="adjustment-content-wrapper">
        <div class="adjustment-add-btn mb-2" style="text-align: end;">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('adjustment-add') }}">Add New Adjustment</a>
        </div>

        <table class="table shadow-lg bg-white mt-3">
            {{-- table head --}}
            <thead class="thead-dark thead-btn">
                <tr>
                    <th>Date</th>
                    <th>Reference No</th>
                    <th>Warehouse</th>
                    <th>Create By</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            {{-- table body --}}
            <tbody id="myTable">
                @foreach ($adjustments as $key => $adjustment)
                <tr>
                    <td>{{$adjustment->datetime}}</td>
                    <td>{{$adjustment->reference_no}}</td>
                    <td>{{$adjustment->warehouse}}</td>
                    <td>{{$adjustment->created_by}}</td>
                    @if ($adjustment->note == null)
                        <td></td>
                    @else
                        <td>{{$adjustment->note}}</td>
                    @endif
                    <td>
                        {{-- action dropdown menu --}}
                        <img type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="{{asset('icon/dashboard/action.png')}}" alt="action icon">
                        {{-- dropdown items --}}
                        <div class="dropdown-menu dropdown-menu-left">
                            {{-- see detail --}}
                            <div class="action-see-detail-wrapper">
                                <a class="dropdown-item" href="{{ route('adjustment-detail', ['id' => $adjustment->id]) }}">See Detail</a>
                            </div>
                            {{-- edit --}}
                            <div class="action-edit-wrapper">
                                <a class="dropdown-item" href="{{url("dashboard/adjustment/$adjustment->id/edit")}}">Edit</a>
                            </div>
                            {{-- delete --}}
                            <div class="action-delete-wrapper">
                                <form action="{{ route('adjustment-delete', ['id' => $adjustment->id]) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="adjustment-delete-btn dropdown-item">
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
{{-- END:: Adjustment --}}

{{-- custom script --}}
@section('dashboard_script')
    <script src="{{asset('js/dashboard/adjustment.js')}}"></script>
    
@endsection
