@extends('layout.dashboard')


{{-- Page Title --}}
@section('page_title','Districts')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Districts</li>
@endsection

@section('dashboard_content')
{{-- Table  --}}
<table class="table shadow-lg bg-white mt-3">
    <thead class="thead-dark thead-btn">
        <tr>
            <th>ID</th>
            <th>District Name</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($districts as $district)
        <tr class="cursor-pointer" data-toggle="collapse" data-target="#district{{$district->district_id}}Collapse">
            <td>{{$district->district_id}}</td>
            <td>{{$district->district_name}}</td>

            <td class="td-options">
                <a class="text-dark mr-1" href="{{ url("dashboard/districts/$district->district_id/edit") }}"><i
                        class="fas fa-edit"></i></a>
                <form action="{{ url("dashboard/districts/$district->district_id") }}" method="POST"
                    class="d-inline-block">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-link btn-district-delete text-dark p-0"><i
                            class="fas fa-trash"></i></button>
                </form>
            </td>

        </tr>
        <tr>
            <td colspan="6" class="p-0 border-0">
                <div class="collapse" id="district{{$district->district_id}}Collapse">
                    @if ($district->sangkats->isEmpty())
                    <div class="text-center pb-3">
                        No Sangkats
                    </div>
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
                            @foreach ($district->sangkats as $sangkat)
                            <tr>
                                <td>{{$sangkat->sangkat_id}}</td>
                                <td>{{$sangkat->sangkat_name}}</td>
                                <td>${{$sangkat->delivery_fee}}</td>
                                <td>
                                    <a class="text-dark mr-1"
                                        href="{{ url("dashboard/sangkats/$sangkat->sangkat_id") }}"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ url("dashboard/sangkats/$sangkat->sangkat_id") }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-link btn-sangkat-delete text-dark p-0"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                {{-- <div class="collapse" id="district{{$district->district_id}}Collapse">

                </div> --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $districts->links() }}
<hr class="w-75 mx-auto">
@endsection

@section('dashboard_script')
<script>
    $('.td-options > a').on('click', function disableCollapse(e){
        e.stopPropagation();
    });
    $('.btn-district-delete, .btn-sangkat-delete').on('click', function disableCollapse(e){
        e.stopPropagation();
        return confirm('Are you sure?') 
    });
</script>
@endsection