@extends('layout.dashboard')


{{-- Page Title --}}
@section('page_title','Create District')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('dashboard/districts') }}" class="breadcrumb-link">Districts</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('dashboard_content')
{{-- Table  --}}
<table class="table shadow-lg bg-white mt-3">
    <thead class="thead-dark thead-btn">
        <tr>
            <th>ID</th>
            <th>District Name</th>
            <th>Submit</th>
        </tr>
    </thead>
    <tbody>
        <tr class="cursor-pointer">
            <form action="{{ url('dashboard/districts', ['id' => $district->district_id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <td style="vertical-align: middle">{{$district->district_id}}</td>
                <td>
                    <div class="form-group row p-0">
                        <label class="col-sm-2 col-form-label">District name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{$district->district_name}}"
                                required autofocus>
                        </div>
                    </div>
                </td>
                <td><button type="submit" class="btn btn-sm btn-dark">Submit</button></td>
            </form>
        </tr>
        <tr>
            <td colspan="6" class="border-0">
                @if ($sangkats->isEmpty())
                <div class="text-center pb-3"> No Sangkats</div>
                @else
                <table class="table shadow-lg bg-white w-75 mx-auto">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sangkat Name</th>
                            <th>Delivery Fee</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sangkats as $sangkat)
                        <tr>
                            <td>{{$sangkat->sangkat_id}}</td>
                            <td>{{$sangkat->sangkat_name}}</td>
                            <td>${{$sangkat->delivery_fee}}</td>
                            <td>
                                <a class="text-dark mr-1" href="{{ url("districts/$district->district_id/edit") }}"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ url("dashboard/sangkats/$sangkat->sangkat_id") }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-link btn-delete text-dark p-0"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </td>
        </tr>
    </tbody>
</table>
@endsection

@section('dashboard_script')

@endsection